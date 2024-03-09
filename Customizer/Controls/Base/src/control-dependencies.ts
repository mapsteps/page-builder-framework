import {
	WpbfControlDependencies,
	WpbfCustomize,
	WpbfReversedControlDependencies,
	WpbfReversedControlDependency,
} from "./interfaces";
import hooks from "@wordpress/hooks";

declare var wp: {
	customize: WpbfCustomize;
	hooks: typeof hooks;
};

declare var wpbfCustomizerControlDependencies: WpbfControlDependencies;

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
				wp.customize.control(ruleSet.dependantControlId).toggle(false);
				continue;
			}

			const dependantDependencies =
				wpbfCustomizerControlDependencies[ruleSet.dependantControlId];

			if (dependantDependencies.length < 2) {
				wp.customize.control(ruleSet.dependantControlId).toggle(true);
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
				wp.customize.control(ruleSet.dependantControlId).toggle(false);
			} else {
				wp.customize.control(ruleSet.dependantControlId).toggle(true);
			}
		}
	}

	function isRuleSatisfied(
		value: string | number,
		operator: string,
		expectedValue: string | number | any[],
	): boolean {
		operator = operator.trim().toLowerCase();

		switch (operator) {
			case "==":
				return value == expectedValue;
			case "===":
				return value === expectedValue;
			case "!=":
				return value != expectedValue;
			case "!==":
				return value !== expectedValue;
			case ">":
				return value > expectedValue;
			case ">=":
				return value >= expectedValue;
			case "<":
				return value < expectedValue;
			case "<=":
				return value <= expectedValue;
			case "in":
				const arr: any[] = Array.isArray(value) ? value : [];
				return arr.includes(expectedValue);
			case "not in":
				const arr2: any[] = Array.isArray(value) ? value : [];
				return !arr2.includes(expectedValue);
		}

		return false;
	}
}
