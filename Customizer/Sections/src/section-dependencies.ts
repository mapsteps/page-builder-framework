import {
	WpbfSectionDependencies,
	WpbfReversedSectionDependencies,
	WpbfReversedSectionDependency,
} from "../../Controls/Base/src/base-interface";
import { isRuleSatisfied } from "../../Controls/Base/src/control-dependencies";

export default function setupSectionDependencies(
	customizer: WpbfCustomize,
	globalSectionDependencies: WpbfSectionDependencies,
) {
	if (!window.wp.customize) return;
	const reversedSectionDependencies: WpbfReversedSectionDependencies = {};

	for (const dependantSectionId in globalSectionDependencies) {
		if (!globalSectionDependencies.hasOwnProperty(dependantSectionId)) {
			continue;
		}

		const sectionDependencies = globalSectionDependencies[dependantSectionId];

		for (const dependency of sectionDependencies) {
			let dependencySettingId = dependency.setting;

			// Backwards compatibility.
			if (!dependencySettingId && dependency.id) {
				dependencySettingId = dependency.id;
			}

			if (!dependencySettingId) {
				continue;
			}

			if (!reversedSectionDependencies[dependencySettingId]) {
				reversedSectionDependencies[dependencySettingId] = [];
			}

			reversedSectionDependencies[dependencySettingId].push({
				dependantSectionId: dependantSectionId,
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
		dependencySettingId: string,
		bindValueChanges: boolean,
	) {
		customizer(dependencySettingId, function (setting) {
			const rules = reversedSectionDependencies[dependencySettingId];

			handleRulesCondition(dependencySettingId, setting.get(), rules);

			if (bindValueChanges) {
				setting.bind(function (newValue: string) {
					handleRulesCondition(dependencySettingId, newValue, rules);
				});
			}
		});
	}

	function handleRulesCondition(
		dependencySettingId: string,
		newValue: string,
		rules: WpbfReversedSectionDependency[],
	) {
		for (const ruleSet of rules) {
			let isDependencySatisfied = isRuleSatisfied(
				newValue,
				ruleSet.operator,
				ruleSet.value,
			);

			if (!isDependencySatisfied) {
				deactivateSection(ruleSet.dependantSectionId);
				continue;
			}

			const dependantDependencies =
				globalSectionDependencies[ruleSet.dependantSectionId];

			if (dependantDependencies.length < 2) {
				activateSection(ruleSet.dependantSectionId);
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
				deactivateSection(ruleSet.dependantSectionId);
			} else {
				activateSection(ruleSet.dependantSectionId);
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
