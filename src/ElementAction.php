<?php

namespace panlatent\craft\actions\bundle;

use Craft;
use craft\base\ElementInterface;
use craft\elements\Entry;
use panlatent\craft\actions\abstract\SavableAction;
use panlatent\craft\actions\abstract\ContextInterface;

class ElementAction extends SavableAction
{
    public string $elementType = Entry::class;

    public ?string $elementAction = null;

    public $query;

    public function execute(ContextInterface $context): bool
    {
        return true;
    }

    public function getSettingsHtml(): ?string
    {
        $elementTypes = Craft::$app->getElements()->getAllElementTypes();

        $elementTypeOptions = [];
        $allElementActionOptions = [];
        $allElementSourceOptions = [];
        foreach ($elementTypes as $elementType) {
            /** @var ElementInterface|string $elementType */
            $elementTypeOptions[] = ['label' => $elementType::displayName(), 'value' => $elementType];
            foreach ($elementType::actions('*') as $action) {
                $allElementActionOptions[$elementType][] = [
                    'label' => $action['label'] ?? $action::displayName(),
                    'value' => $action['type'] ?? $action,
                ];
            }

            $allElementSourceOptions[$elementType] = [];
            foreach($elementType::sources('index') as $source) {
                if (isset($source['heading'])) {
                    continue;
                }
                $allElementSourceOptions[$elementType][] = [
                    'label' => $source['label'],
                    'value' => $source['key'],
                    'enabled' => false,
                ];
            }
        }

        return Craft::$app->getView()->renderTemplate('schedule/_components/actions/ElementAction/settings', [
            'action' => $this,
            'elementTypeOptions' => $elementTypeOptions,
            'allElementActionOptions' => $allElementActionOptions,
            'allElementSourceOptions' => $allElementSourceOptions,
        ]);
    }
}