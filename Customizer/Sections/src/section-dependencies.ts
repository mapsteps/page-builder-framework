import {
	WpbfControlDependencies,
	WpbfReversedControlDependencies,
	WpbfReversedControlDependency,
} from "../../Controls/Base/src/interface";
import { isRuleSatisfied } from "../../Controls/Base/src/control-dependencies";

export default function setupSectionDependencies(
	globalSectionDependencies: WpbfControlDependencies,
) {
	if (!window.wp.customize) return;
	const reversedSectionDependencies: WpbfReversedControlDependencies = {};

	for (const sectionId in globalSectionDependencies) {
		if (!globalSectionDependencies.hasOwnProperty(sectionId)) {
			continue;
		}

		const sectionDependencies = globalSectionDependencies[sectionId];

		for (const dependency of sectionDependencies) {
			if (!reversedSectionDependencies[dependency.id]) {
				reversedSectionDependencies[dependency.id] = [];
			}

			reversedSectionDependencies[dependency.id].push({
				dependantId: sectionId,
				operator: dependency.operator,
				value: dependency.value,
			});
		}
	}

	const customizer = window.wp.customize;

	customizer.bind("ready", function () {
		for (const controlId in reversedSectionDependencies) {
			if (!reversedSectionDependencies.hasOwnProperty(controlId)) {
				continue;
			}

			listenDependencyControl(controlId);
		}
	});

	function listenDependencyControl(dependencyControlId: string) {
		customizer(dependencyControlId, function (setting) {
			const rules = reversedSectionDependencies[dependencyControlId];

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
				customizer.section(ruleSet.dependantId)?.active(false);
				continue;
			}

			const dependantDependencies =
				globalSectionDependencies[ruleSet.dependantId];

			if (dependantDependencies.length < 2) {
				customizer.section(ruleSet.dependantId)?.active(true);
				continue;
			}

			let otherRulesSatisfied = true;

			for (const dependantDependency of dependantDependencies) {
				if (dependantDependency.id === dependencyControlId) {
					continue;
				}

				const dependantDependencyValue = customizer(
					dependantDependency.id,
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
				customizer.section(ruleSet.dependantId)?.active(false);
			} else {
				customizer.section(ruleSet.dependantId)?.active(true);
			}
		}
	}
}
