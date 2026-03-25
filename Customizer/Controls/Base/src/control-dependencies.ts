import _ from "lodash";
import {
	WpbfControlDependencies,
	WpbfReversedControlDependencies,
	WpbfReversedControlDependency,
} from "./base-interface";

export default function setupControlDependencies(
	globalControlDependencies: WpbfControlDependencies,
) {
	if (!window.wp.customize) return;
	const reversedControlDependencies: WpbfReversedControlDependencies = {};

	for (const dependantControlId in globalControlDependencies) {
		if (!globalControlDependencies.hasOwnProperty(dependantControlId)) {
			continue;
		}

		const controlDependencies = globalControlDependencies[dependantControlId];

		for (const dependency of controlDependencies) {
			let dependencySettingId = dependency.setting;

			// Backwards compatibility.
			if (!dependencySettingId && dependency.id) {
				dependencySettingId = dependency.id;
			}

			if (!dependencySettingId) {
				continue;
			}

			if (!reversedControlDependencies[dependencySettingId]) {
				reversedControlDependencies[dependencySettingId] = [];
			}

			reversedControlDependencies[dependencySettingId].push({
				dependantControlId: dependantControlId,
				operator: dependency.operator,
				value: dependency.value,
			});
		}
	}

	const customizer = window.wp.customize;

	customizer.bind("ready", function () {
		for (const dependencySettingId in reversedControlDependencies) {
			if (!reversedControlDependencies.hasOwnProperty(dependencySettingId)) {
				continue;
			}

			listenDependencyControl(dependencySettingId);
		}

		// Re-evaluate dependencies when a control is embedded (deferred embedding).
		window.wp.hooks.addAction(
			"wpbf.dynamicControl.actuallyEmbed.after",
			"wpbf/controlDependencies",
			(control: { id: string }) => {
				if (!control?.id) return;
				if (!globalControlDependencies[control.id]) return;

				reevaluateControlDependencies(control.id);
			},
		);

		// Re-evaluate dependencies when a control is moved across sections.
		window.wp.hooks.addFilter(
			"wpbf.controlDependencies.reevaluate",
			"wpbf/controlDependencies",
			(handled: boolean, controlId: string) => {
				if (!controlId) return handled;
				if (!globalControlDependencies[controlId]) return handled;

				reevaluateControlDependencies(controlId);
				return true;
			},
		);
	});

	function reevaluateControlDependencies(controlId: string) {
		const dependencies = globalControlDependencies[controlId];
		if (!dependencies || dependencies.length === 0) return;

		let allSatisfied = true;

		for (const dependency of dependencies) {
			let dependencySettingId = dependency.setting;

			// Backwards compatibility.
			if (!dependencySettingId && dependency.id) {
				dependencySettingId = dependency.id;
			}

			if (!dependencySettingId) continue;

			const settingValue = customizer(dependencySettingId)?.get();

			if (!isRuleSatisfied(settingValue, dependency.operator, dependency.value)) {
				allSatisfied = false;
				break;
			}
		}

		if (allSatisfied) {
			showControl(controlId);
		} else {
			hideControl(controlId);
		}
	}

	function listenDependencyControl(dependencySettingId: string) {
		customizer(dependencySettingId, function (setting) {
			const rules = reversedControlDependencies[dependencySettingId];

			handleRulesCondition(dependencySettingId, setting.get(), rules);

			setting.bind(function (newValue: string) {
				handleRulesCondition(dependencySettingId, newValue, rules);
			});
		});
	}

	function handleRulesCondition(
		dependencySettingId: string,
		newValue: string,
		rules: WpbfReversedControlDependency[],
	) {
		for (const ruleSet of rules) {
			let isDependencySatisfied = isRuleSatisfied(
				newValue,
				ruleSet.operator,
				ruleSet.value,
			);

			if (!isDependencySatisfied) {
				hideControl(ruleSet.dependantControlId);
				continue;
			}

			const dependantDependencies =
				globalControlDependencies[ruleSet.dependantControlId];

			if (dependantDependencies.length < 2) {
				showControl(ruleSet.dependantControlId);
				continue;
			}

			let otherRulesSatisfied = true;

			for (const dependantDependency of dependantDependencies) {
				let dependantDependencySettingId = dependantDependency.setting;

				// Backwards compatibility.
				if (!dependantDependencySettingId && dependantDependency.id) {
					dependantDependencySettingId = dependantDependency.id;
				}

				if (!dependantDependencySettingId) {
					continue;
				}

				if (dependantDependencySettingId === dependencySettingId) {
					continue;
				}

				const dependantDependencyValue = customizer(
					dependantDependencySettingId,
				).get();

				if (
					!isRuleSatisfied(
						dependantDependencyValue,
						dependantDependency.operator,
						dependantDependency.value,
					)
				) {
					otherRulesSatisfied = false;
					break;
				}
			}

			if (!otherRulesSatisfied) {
				hideControl(ruleSet.dependantControlId);
			} else {
				showControl(ruleSet.dependantControlId);
			}
		}
	}

	function hideControl(controlId: string) {
		if (insideInactiveTab(customizer.control(controlId)?.container[0])) {
			customizer
				.control(controlId)
				?.container.removeClass("wpbf-tab-item-hidden");

			customizer
				.control(controlId)
				?.container.addClass("wpbf-tab-item-invisible");
		}

		customizer.control(controlId)?.onChangeActive(false, {
			completeCallback: () => {
				if (
					customizer
						.control(controlId)
						?.container.hasClass("wpbf-tab-item-invisible")
				) {
					customizer
						.control(controlId)
						?.container.removeClass("wpbf-tab-item-invisible");

					customizer
						.control(controlId)
						?.container.addClass("wpbf-tab-item-hidden");
				}
			},
		});
	}

	function showControl(controlId: string) {
		customizer.control(controlId)?.onChangeActive(true, {});
	}
}

function insideInactiveTab(el: HTMLElement | undefined | null) {
	if (!el) return false;
	if (!el.dataset.wpbfParentTabId) return false;
	if (!el.classList.contains("wpbf-tab-item-hidden")) return false;
	return true;
}

export function isRuleSatisfied(
	actualValue: any,
	operator: string,
	expectedValue: any,
): boolean {
	operator = operator.trim().toLowerCase();

	switch (operator) {
		case "==":
			return actualValue == expectedValue;
		case "===":
			return actualValue === expectedValue;
		case "!=":
			return actualValue != expectedValue;
		case "!==":
			return actualValue !== expectedValue;
		case ">":
			return actualValue > expectedValue;
		case ">=":
			return actualValue >= expectedValue;
		case "<":
			return actualValue < expectedValue;
		case "<=":
			return actualValue <= expectedValue;
		case "in":
			return compareInOperator(actualValue, expectedValue);
		case "not in":
			return !compareInOperator(actualValue, expectedValue);
	}

	return false;
}

function compareInOperator(actualValue: any, expectedValue: any): boolean {
	if (Array.isArray(expectedValue)) {
		const expectedValueArray: any[] = expectedValue;
		let found = false;

		if (Array.isArray(actualValue)) {
			const actualValueArray: any[] = actualValue;

			for (let i = 0; i < actualValueArray.length; ++i) {
				if (expectedValueArray.includes(actualValueArray[i])) {
					found = true;
					break;
				}
			}
		} else {
			if (expectedValueArray.includes(actualValue)) {
				found = true;
			}
		}

		return found;
	}

	if (Array.isArray(actualValue)) {
		const actualValueArray: any[] = actualValue;
		return actualValueArray.includes(expectedValue);
	}

	if (_.isObject(actualValue)) {
		const actualValueObj: Record<string, any> = actualValue;

		if (!_.isUndefined(actualValueObj[expectedValue])) {
			return true;
		}

		for (const prop in actualValueObj) {
			if (!actualValueObj.hasOwnProperty(prop)) continue;

			if (actualValueObj[prop] === expectedValue) {
				return true;
			}
		}
	}

	if ("string" === typeof actualValue) {
		if ("string" === typeof expectedValue) {
			return (
				-1 < expectedValue.indexOf(actualValue) &&
				-1 < actualValue.indexOf(expectedValue)
			);
		}

		return -1 < expectedValue.indexOf(actualValue);
	}

	return false;
}
