<?php

namespace KraenkVisuell\NovaSettings\Tests\Feature;

use KraenkVisuell\NovaSettings\NovaSettings;
use KraenkVisuell\NovaSettings\Tests\IntegrationTestCase;
use Laravel\Nova\Fields\Text;

class SettingsRetrieveTest extends IntegrationTestCase
{
    public function test_general_fields_are_returned_with_no_path()
    {
        NovaSettings::addSettingsFields([
            Text::make('Test'),
            Text::make('TestOne'),
        ]);

        NovaSettings::addSettingsFields([
            Text::make('TestTwo'),
            Text::make('TestThree'),
            Text::make('TestFour'),
        ], [], 'Other');

        $request = $this->getJson(route('nova-settings.get'));

        $request->assertStatus(200);
        $request->assertJsonCount(2, 'fields');
    }

    public function test_general_fields_are_returned_with_general_path()
    {
        NovaSettings::addSettingsFields([
            Text::make('Test'),
            Text::make('TestOne'),
        ]);

        NovaSettings::addSettingsFields([
            Text::make('TestTwo'),
            Text::make('TestThree'),
            Text::make('TestFour'),
        ], [], 'Other');

        $request = $this->getJson(route('nova-settings.get', ['path' => 'general']));

        $request->assertStatus(200);
        $request->assertJsonCount(2, 'fields');
    }

    public function test_other_fields_are_returned_with_other_path()
    {
        NovaSettings::addSettingsFields([
            Text::make('Test'),
            Text::make('TestOne'),
        ]);

        NovaSettings::addSettingsFields([
            Text::make('TestTwo'),
            Text::make('TestThree'),
            Text::make('TestFour'),
        ], [], 'Other');

        $request = $this->getJson(route('nova-settings.get', ['path' => 'other']));

        $request->assertStatus(200);
        $request->assertJsonCount(3, 'fields');
    }
}
