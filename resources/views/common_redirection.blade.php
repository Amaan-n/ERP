<template class="users_templates">
    <option value="">Please select a value</option>
    @foreach(\App\Providers\FormList::getUsers() as $user)
        <option value="{{ $user->id }}" data-package-slug="{{ $user->slug }}">
            {{ $user->name }}
        </option>
    @endforeach
</template>

<script typeof="text/javascript">
    $(document).ready(function () {
        $(document).off('change', 'select[name="redirection_type"]');
        $(document).on('change', 'select[name="redirection_type"]', function () {
            $(document).find('.for_internal_redirection, .for_external_redirection').addClass('d-none');
            $(document).find('.for_internal_redirection').find('select').val('').trigger('click');
            $(document).find('.for_external_redirection').find('input').val('');

            if ($(this).val() === 'internal') {
                $(document).find('.for_internal_redirection').removeClass('d-none');
            }

            if ($(this).val() === 'external') {
                $(document).find('.for_external_redirection').removeClass('d-none');
            }
        });

        $(document).off('change', 'select[name="redirection_module"]');
        $(document).on('change', 'select[name="redirection_module"]', function () {
            if ($(this).val() === '') {
                $(document).find('select[name="redirection_module_id"]').html('<option value="">Please select a value</option>');
                return false;
            }

            let template_html = document.querySelector('.' + $(this).val() + '_templates');
            let clone_node = template_html.content.cloneNode(true);
            let clone_html = document.importNode(clone_node, true);
            $(document).find('select[name="redirection_module_id"]').html(clone_html);
        });
    });
</script>
