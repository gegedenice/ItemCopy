(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var config = window.ItemCopy;
        if (!config) {
            return;
        }

        document.querySelectorAll('table tbody tr').forEach(function (row) {
            var checkbox = row.querySelector('input[name="resource_ids[]"]');
            var actions = row.querySelector('ul.actions');

            if (!checkbox || !actions || actions.querySelector('.item-copy')) {
                return;
            }

            var item = document.createElement('li');
            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'o-icon-add item-copy';
            button.title = config.copyLabel;
            button.setAttribute('aria-label', config.copyLabel);
            button.addEventListener('click', function () {
                if (!window.confirm(config.confirmMessage)) {
                    return;
                }

                var form = document.createElement('form');
                var csrf = document.createElement('input');
                form.method = 'post';
                form.action = config.action.replace('__ITEM_ID__', checkbox.value);
                form.hidden = true;
                csrf.type = 'hidden';
                csrf.name = 'csrf';
                csrf.value = config.csrf;
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            });

            item.appendChild(button);
            actions.insertBefore(item, actions.firstChild);
        });
    });
}());
