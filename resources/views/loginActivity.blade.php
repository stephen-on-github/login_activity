@extends('layouts.site')

@section('title')
    Login activity
@endsection

@section('content')
    <div class="container px-2" id="app">
        <form class="columns" id="login-activity-filters">
            {{-- Region picker --}}
            <div class="column is-12-mobile is-3-tablet">
                @component('components.form.multiselect')
                    @slot('optionClass', 'login-activity-filter')
                    @slot('id', 'login-activity-region')
                    @slot('label', 'Region')
                    @slot('name', 'location_ids')
                    @slot('options', $locations->pluck('name', 'id'))
                    @slot('mandatoryOptions', $mainHq->pluck('name', 'id'))
                    @slot('icon', 'globe')
                @endcomponent
            </div>

            {{-- Date-range picker --}}
            <div class="column is-12-mobile is-6-tablet">
                @component('components.form.daterange')
                    @slot('hiddenClass', 'login-activity-filter')
                    @slot('id', 'login-activity-daterange')
                    @slot('label', 'Date range')
                    @slot('name', 'date')
                @endcomponent
            </div>

            {{-- Interval picker --}}
            <div class="column is-12-mobile is-3-tablet">
                @component('components.form.select')
                    @slot('class', 'login-activity-filter')
                    @slot('id', 'login-activity-interval')
                    @slot('label', 'Interval')
                    @slot('name', 'interval')
                    @slot('options', [
                        5  => 'Every 5 minutes',
                        10 => 'Every 10 minutes',
                        15 => 'Every 15 minutes',
                        30 => 'Every 30 minutes',
                        60 => 'Every hour'
                    ])
                    @slot('selected', 60)
                    @slot('icon', 'clock-o')
                @endcomponent
            </div>
        </form>

        {{-- Chart. To be populated by the JavaScript. --}}
        <div id="login-activity-chart"></div>
    </div>
@endsection