{{-- Component for adding date-range picker form fields to pages. --}}
<div class="field">
    @if (!empty($label))
        <label class="label" for="{{ $id }}">{{ $label }}</label>
    @endif

    <div class="control has-icons-left">
        {{-- Hidden fields, with the dates in ISO format --}}
        <input
            type="hidden"
            @if (!empty($name))
                name="start_{{ $name }}"
            @endif
            value="{{ $startDate ?? '' }}"

            @if (!empty($hiddenClass))
                class=" {{ $hiddenClass }}"
            @endif
            id="{{ $id }}-start"
        />
        <input
            type="hidden"
            @if (!empty($name))
                name="end_{{ $name }}"
            @endif
            value="{{ $endDate ?? '' }}"

            @if (!empty($hiddenClass))
                class=" {{ $hiddenClass }}"
            @endif
            id="{{ $id }}-end"
        />

        {{-- Visual field, with the dates in a pretty format --}}
        <input
            type="text"
            @if (!empty($name))
                name="{{ $name }}"
            @endif

            value="{{ $startDate ? date('j F Y', strtotime($startDate)) : '' }}
                {{ $endDate ? ' - ' . date('j F Y', strtotime($endDate)) : '' }}"

            class="input daterangepicker is-fullwidth {{ $class ?? '' }}"
            id="{{ $id }}"
        />

        {{-- Icon will be a calendar, unless deliberately suppressed or a different icon chosen --}}
        @if (!isset($icon) || $icon !== false)
            <span class="icon is-left">
                <span class="fa fa-{{ $icon ?? 'calendar' }}" aria-hidden="true"></span>
            </span>
        @endif
    </div>
</div>

