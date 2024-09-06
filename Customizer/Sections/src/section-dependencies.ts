import {
	WpbfControlDependencies,
	WpbfReversedControlDependencies,
	WpbfReversedControlDependency,
} from "../../Controls/Base/src/base-interface";
import { isRuleSatisfied } from "../../Controls/Base/src/control-dependencies";

export default function setupSectionDependencies(
	customizer: WpbfCustomize,
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

	customizer.bind("ready", function () {
		setupDependencyControlListener(true);
	});

	/**
	 * The section dependency system actually works.
	 * But there was a bug where hidden sections are shown again after preview iframe is fully loaded.
	 * Re-running the dependency checking on window "load" event solve the issue.
	 */
	window.addEventListener("load", function () {
		setupDependencyControlListener(false);
	});

	function setupDependencyControlListener(bindValueChanges: boolean) {
		for (const controlId in reversedSectionDependencies) {
			if (!reversedSectionDependencies.hasOwnProperty(controlId)) {
				continue;
			}

			listenDependencyControl(controlId, bindValueChanges);
		}
	}

	function listenDependencyControl(
		dependencyControlId: string,
		bindValueChanges: boolean,
	) {
		customizer(dependencyControlId, function (setting) {
			const rules = reversedSectionDependencies[dependencyControlId];

			handleRulesCondition(dependencyControlId, setting.get(), rules);

			if (bindValueChanges) {
				setting.bind(function (newValue: string) {
					handleRulesCondition(dependencyControlId, newValue, rules);
				});
			}
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
				deactivateSection(ruleSet.dependantId);
				continue;
			}

			const dependantDependencies =
				globalSectionDependencies[ruleSet.dependantId];

			if (dependantDependencies.length < 2) {
				activateSection(ruleSet.dependantId);
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
				deactivateSection(ruleSet.dependantId);
			} else {
				activateSection(ruleSet.dependantId);
			}
		}
	}

	function activateSection(sectionId: string) {
		customizer.section(sectionId).activate();
	}

	function deactivateSection(sectionId: string) {
		customizer.section(sectionId).deactivate();
	}
}
