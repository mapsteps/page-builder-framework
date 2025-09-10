import _ from "lodash";
import {
	WpbfControlDependency,
	WpbfCustomize,
	WpbfReversedControlDependencies,
	WpbfReversedControlDependency,
} from "./interface";
import hooks from "@wordpress/hooks";

declare var wp: {
	customize: WpbfCustomize;
	hooks: typeof hooks;
};

declare var wpbfCustomizerControlDependencies: Record<
	string,
	WpbfControlDependency[]
>;

export default function setupControlDependencies() {
	const reversedControlDependencies: WpbfReversedControlDependencies = {};

	for (const controlId in wpbfCustomizerControlDependencies) {
		if (!wpbfCustomizerControlDependencies.hasOwnProperty(controlId)) {
			continue;
		}

		const controlDependencies = wpbfCustomizerControlDependencies[controlId];

		for (const dependency of controlDependencies) {
			if (!reversedControlDependencies[dependency.id]) {
				reversedControlDependencies[dependency.id] = [];
			}

			reversedControlDependencies[dependency.id].push({
				dependantControlId: controlId,
				operator: dependency.operator,
				value: dependency.value,
			});
		}
	}

	wp.customize.bind("ready", function () {
		for (const controlId in reversedControlDependencies) {
			if (!reversedControlDependencies.hasOwnProperty(controlId)) {
				continue;
			}

			listenDependencyControl(controlId);
		}
	});

	function listenDependencyControl(dependencyControlId: string) {
		wp.customize(dependencyControlId, function (setting) {
			const rules = reversedControlDependencies[dependencyControlId];

			handleRulesCondition(dependencyControlId, setting.get(), rules);

			setting.bind(function (newValue: string) {
				handleRulesCondition(dependencyControlId, newValue, rules);
			});
		});
	}

	function handleRulesCondition(
		dependencyControlId: string,
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
				wp.customize.control(ruleSet.dependantControlId)?.toggle(false);
				continue;
			}

			const dependantDependencies =
				wpbfCustomizerControlDependencies[ruleSet.dependantControlId];

			if (dependantDependencies.length < 2) {
				wp.customize.control(ruleSet.dependantControlId)?.toggle(true);
				continue;
			}

			let otherRulesSatisfied = true;

			for (const dependantDependency of dependantDependencies) {
				if (dependantDependency.id === dependencyControlId) {
					continue;
				}

				const dependantDependencyValue = wp
					.customize(dependantDependency.id)
					.get();

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
				wp.customize.control(ruleSet.dependantControlId)?.toggle(false);
			} else {
				wp.customize.control(ruleSet.dependantControlId)?.toggle(true);
			}
		}
	}

	function isRuleSatisfied(
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
}
