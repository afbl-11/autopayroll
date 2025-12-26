@vite(['resources/css/theme.css', 'resources/css/employee_registration/basicInformation.css'])

<x-app title="Edit Government & Bank Information">
    <section class="main-content">
        <div class="form-wrapper">
            <form method="POST" action="{{ route('employee.update.government', $employee) }}">
                @csrf
                @method('PUT')

                    <h5>Government Requirements</h5>

                    {{-- Bank and SSS --}}
                    <div class="field-row">
                        <x-form-input label="Bank Account Number"
                                      name="bank_account_number"
                                      id="bank_account_number"
                                      required
                                      placeholder="10-16 digits"
                                      :value="$employee->bank_account_number"
                        />

                        <x-form-input label="Social Security Number"
                                      name="sss_number"
                                      id="sss_number"
                                      placeholder="10 digits"
                                      :value="$employee->sss_number"
                        />
                    </div>

                    {{-- PhilHealth and Pag-IBIG --}}
                    <div class="field-row">
                        <x-form-input label="PhilHealth Number"
                                      name="phil_health_number"
                                      id="phil_health_number"
                                      placeholder="12 digits"
                                      :value="$employee->phil_health_number"
                        />

                        <x-form-input label="Pag-IBIG Number"
                                      name="pag_ibig_number"
                                      id="pag_ibig_number"
                                      placeholder="12 digits"
                                      :value="$employee->pag_ibig_number"
                        />
                    </div>

                    {{-- TIN --}}
                    <div class="field-row">
                        <x-form-input label="TIN"
                                      name="tin_number"
                                      id="tin_number"
                                      placeholder="9-12 digits"
                                      :value="$employee->tin_number"
                        />
                    </div>
                <x-button-submit>Save</x-button-submit>
            </form>
        </div>
    </section>
</x-app>
<script>
document.addEventListener('DOMContentLoaded', () => {

    const formatField = (fieldId, patternFunc) => {
        const field = document.getElementById(fieldId);
        if (!field) return;

        field.addEventListener('input', () => {
            let value = field.value.replace(/\D/g, ''); // digits only
            field.value = patternFunc(value);
        });
    };

    formatField('sss_number', value => {
        if (value.length > 2 && value.length <= 9) {
            value = value.replace(/(\d{2})(\d+)/, '$1-$2');
        } else if (value.length > 9) {
            value = value.replace(/(\d{2})(\d{7})(\d+)/, '$1-$2-$3');
        }
        return value;
    });

    formatField('phil_health_number', value => {
        if (value.length > 2 && value.length <= 11) {
            value = value.replace(/(\d{2})(\d+)/, '$1-$2');
        } else if (value.length > 11) {
            value = value.replace(/(\d{2})(\d{9})(\d+)/, '$1-$2-$3');
        }
        return value;
    });

    formatField('pag_ibig_number', value => {
        if (value.length > 4 && value.length <= 8) {
            value = value.replace(/(\d{4})(\d+)/, '$1-$2');
        } else if (value.length > 8) {
            value = value.replace(/(\d{4})(\d{4})(\d+)/, '$1-$2-$3');
        }
        return value;
    });

    formatField('tin_number', value => {
        if (value.length > 3 && value.length <= 6) {
            value = value.replace(/(\d{3})(\d+)/, '$1-$2');
        } else if (value.length > 6 && value.length <= 9) {
            value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1-$2-$3');
        } else if (value.length > 9) {
            value = value.replace(/(\d{3})(\d{3})(\d{3})(\d+)/, '$1-$2-$3-$4');
        }
        return value;
    });

    const bankField = document.getElementById('bank_account_number');
    if (bankField) {
        bankField.addEventListener('input', () => {
            bankField.value = bankField.value.replace(/\D/g, '');
        });
    }
});
</script>