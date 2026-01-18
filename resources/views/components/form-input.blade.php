@props([
    'type' => 'text',
    'name' => '',
    'id' => '',
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'noDefault' => false,
    'readOnly' => false,
    'togglePassword' => false,
    'maxlength' => null,
    'multiple' => false,
    'accept' => null,
])

<div @if(!$noDefault){{ $attributes->class('field-input') }} @endif>
    @if($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <div style="position:relative;">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"
            value="{{ old($name, $value ?? '') }}"
            @if($readOnly)
                readonly
            @endif
            @if($togglePassword)
                data-toggle-password="true"
            @endif
            @if($maxlength)
                maxlength="{{ $maxlength }}"
            @endif
            @if($multiple)
                multiple
            @endif
            @if($accept)
                accept="{{ $accept }}"
            @endif
        >

        @if($togglePassword)
            <span class="toggle-eye"
                  data-target="{{ $id }}"
                  style="
            position:absolute;
            right:10px;
            top:50%;
            transform:translateY(-50%);
            cursor:pointer;
            width:20px;
            height:20px;
            display:flex;
            align-items:center;
            justify-content:center;
        "
            >
        <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5c-7 0-11 7-11 7s4 7 11 7 11-7 11-7-4-7-11-7z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>

        {{-- Eye-Off icon --}}
        <svg class="eye-off-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             style="display:none;">
            <path d="M17.94 17.94A10.07 10.07 0 1 1 6.06 6.06"></path>
            <path d="m1 1 22 22"></path>
        </svg>
    </span>
        @endif

    </div>

    @error($id)
    <small class="error_message">{{ $message }}</small>
    @enderror
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".toggle-eye").forEach((eye) => {
            eye.addEventListener("click", function () {
                const input = document.getElementById(this.dataset.target);
                if (!input) return;

                const eyeIcon = this.querySelector(".eye-icon");
                const eyeOffIcon = this.querySelector(".eye-off-icon");

                if (input.type === "password") {
                    input.type = "text";
                    eyeIcon.style.display = "none";
                    eyeOffIcon.style.display = "block";
                } else {
                    input.type = "password";
                    eyeIcon.style.display = "block";
                    eyeOffIcon.style.display = "none";
                }
            });
        });
    });

</script>
