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
	});

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
				customizer.control(ruleSet.dependantControlId)?.toggle(false);
				continue;
			}

			const dependantDependencies =
				globalControlDependencies[ruleSet.dependantControlId];

			if (dependantDependencies.length < 2) {
				customizer.control(ruleSet.dependantControlId)?.toggle(true);
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
				customizer.control(ruleSet.dependantControlId)?.toggle(false);
			} else {
				customizer.control(ruleSet.dependantControlId)?.toggle(true);
			}
		}
	}
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
