{{-- Component for adding select lists to pages --}}
<div class="field">
    @if (!empty($label))
        <label class="label" for="{{ $id }}">{{ $label }}</label>
    @endif

    <div class="control has-icons-left">
        <div class="select is-fullwidth">
            <select class="input {{ $class ?? '' }}" id="{{ $id }}" name="{{ $name ?? '' }}">
                @if (!isset($default))
                    <option value="">-- Please select --</option>
                @endif

                @foreach ($options as $key => $value)
                    <option
                        value="{{ $key }}"
                        @if (isset($selected) && $selected == $key)
                            selected="selected"
                        @endif
                    >{{ $value }}</option>
                @endforeach
            </select>

            @if (!empty($icon))
                <span class="icon is-left">
                    <span class="fa fa-{{ $icon }}" aria-hidden="true"></span>
                </span>
            @endif
        </div>
    </div>
</div>

