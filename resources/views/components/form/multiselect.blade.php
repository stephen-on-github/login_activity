{{-- Component for adding multiselects to pages --}}
<div class="field">
    @if (!empty($label))
        <label class="label" for="{{ $id }}">{{ $label }}</label>
    @endif

    <div class="control has-icons-left">
        <div class="dropdown">
            <div class="dropdown-trigger">
                <button type="button" class="input select is-fullwidth has-text-left" aria-haspopup="true" aria-controls="dropdown-menu">
                    @if (!empty($icon))
                        <span class="icon is-left">
                            <span class="fa fa-{{ $icon }}" aria-hidden="true"></span>
                        </span>
                    @endif

                    <span>{{ $label }}</span>
                </button>
            </div>

            <div class="dropdown-menu" id="dropdown-menu" role="menu" style="width: 100%;">
                <div class="dropdown-content">
                    {{-- The multiselect may have one group of mandatory options. This will display, as readonly --}}
                    @if (isset($mandatoryOptions))
                        @foreach ($mandatoryOptions as $key => $value)
                            <label class="dropdown-item checkbox checkbox-has-helper is-size-6">
                                <input type="hidden" name="{{ $name }}[]" value="{{ $key }}" />
                                <input
                                    type="checkbox"
                                    class="{{ $optionClass ?? '' }}"
                                    checked="checked"
                                    {{-- A checkbox cannot be readonly. Instead making it disabled, while also having
                                        a hidden field --}}
                                    disabled="disabled"
                                />
                                <span class="checkbox-helper" aria-hidden="true"></span>
                                {{ $value }}
                            </label>
                        @endforeach

                        <hr class="dropdown-divider">
                    @endif

                    @foreach ($options as $key => $value)
                        <label class="dropdown-item checkbox checkbox-has-helper is-size-6">
                            <input
                                type="checkbox"
                                name="{{ $name }}[]"
                                value="{{ $key }}"
                                class="{{ $optionClass ?? '' }}"
                                @if (isset($selected) && in_array($key, $selected))
                                    checked="checked"
                                @endif
                            />
                            <span class="checkbox-helper" aria-hidden="true"></span>
                            {{ $value }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
