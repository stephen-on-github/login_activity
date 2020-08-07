{{-- Component for adding date-range picker form fields to pages. --}}
<div class="field">
    @if (!empty($label))
        <label class="label" for="{{ $id }}">{{ $label }}</label>
    @endif

    <div class="control has-icons-left">
        {{-- Hidden fields, with the dates in ISO format --}}
        <input
            type="hidden" {!! isset($name) ? 'name="start_' . $name . '"' : '' !!}
            class=" {{ $hiddenClass ?? '' }}"
            id="{{ $id }}-start"
        />
        <input
            type="hidden" {!! isset($name) ? 'name="end_'   . $name . '"' : '' !!}
            class=" {{ $hiddenClass ?? '' }}"
            id="{{ $id }}-end"
        />

        {{-- Visual field, with the dates in a pretty format --}}
        <input
            type="text"
            {{ isset($name) ? 'name="' . $name . '"' : '' }}
            id="{{ $id }}"
            class="input daterangepicker is-fullwidth {{ $class ?? '' }}"
        />

        {{-- Icon will be a calendar, unless deliberately suppressed or a different icon chosen --}}
        @if (!isset($icon) || $icon !== false)
            <span class="icon is-left">
                <span class="fa fa-{{ $icon ?? 'calendar' }}" aria-hidden="true"></span>
            </span>
        @endif
    </div>
</div>

