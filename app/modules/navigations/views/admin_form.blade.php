{{ Form::errors($errors) }}

@if (isset($model))
    {{ Form::model($model, ['route' => ['admin.navigations.update', $model->id], 'method' => 'PUT']) }}
@else
    {{ Form::open(['url' => 'admin/navigations']) }}
@endif
    {{ Form::smartText('title', trans('app.title')) }} 

    <table id="items-table" class="table table-hover">
        <thead>
            <tr>
                <th>{{ trans('app.title') }}</th>
                <th class="urls">{{ trans('app.url') }}</th>
                <th class="actions">{{ trans('app.actions') }}</th>
            </tr>            
        </thead>
        <tbody>{{-- content genereated by JS below --}}</tbody>
    </table>

    {{ Form::button(HTML::fontIcon('plus-circle').' '.trans('app.create'), ['id' => 'item_add', 'class' => 'btn btn-default']) }}

    {{ Form::hidden('items') }}

    {{ Form::actions() }}
{{ Form::close() }}

<script>
    $(document).ready(function()
    {
        var $items = $('.page input[name=items]');
        var items = JSON.parse($items.val() ? $items.val() : '[]'); // Array of objects
        var $tableBody = $('#items-table tbody');

        var template = '<div data-index="%%index%%"> {{ Form::smartText('item_title', trans('app.title')) }} {{ Form::smartText('item_url', trans('app.url')) }}</div>';

        contentify.templateManager.add('itemForm', template);

        function store()
        {
            $items.val(JSON.stringify(items));
        }

        function createUiItem(item, index)
        {
            var actions = '<a class="icon-link" data-action="up" href="#">' + contentify.fontIcon('chevron-up') + '</a>' +
                '<a class="icon-link" data-action="down" href="#">' +  contentify.fontIcon('chevron-down') + '</a>' +
                '<a class="icon-link" data-action="left" href="#">' + contentify.fontIcon('chevron-left') + '</a>' +
                '<a class="icon-link" data-action="right" href="#">' + contentify.fontIcon('chevron-right') + '</a>' +
                '<a class="icon-link" data-action="edit" href="#">' + contentify.fontIcon('edit') + '</a>' + 
                '<a class="icon-link" data-action="delete" href="#">' + contentify.fontIcon('trash') + '</a>';

            var $tr = $('<tr>').addClass('item-level-' + item.level).attr('data-index', index).append(
                $('<td>').text(item.title)
            ).append(
                $('<td>').text(item.url)
            ).append(
                $('<td>').html(actions)
            );

            $tr.find('a').click(function(event)
            {
                event.preventDefault();

                var action = $(this).attr('data-action');
                var index = parseInt($(this).parent().parent().attr('data-index'));

                switch (action) {
                    case 'up':
                        if (index > 0) {
                            var tempItem = items[index - 1];
                            items[index - 1] = items[index];
                            items[index] = tempItem;
                        }
                        break;
                    case 'down':
                        if (index < items.length - 1) {
                            var tempItem = items[index + 1];
                            items[index + 1] = items[index];
                            items[index] = tempItem;
                        }
                        break;
                    case 'left':
                        if (items[index].level > 0) {
                            items[index].level--;
                        }
                        break;
                    case 'right':
                        if (items[index].level < 5) {
                            items[index].level++;
                        }
                        break;
                    case 'edit':
                        var content = contentify.templateManager.get('itemForm', {index: index});
                        var $content = $(content);

                        $content.find('#item_title').val(items[index].title);
                        $content.find('#item_url').val(items[index].url);

                        var $footer = $('<button>').text('{{ trans('app.save') }}').click(function()
                        {
                            items[index].title = $('#item_title').val();
                            items[index].url = $('#item_url').val();
                            renderAll();
                            store();
                            contentify.closeModal();
                        });

                        contentify.modal('{{ trans('app.item') }}', $content, $footer);

                        break;
                    case 'delete':
                        items.splice(index, 1);
                        break;
                }

                renderAll();
                store();             
            });

            return $tr;
        }

        function renderAll()
        {
            $tableBody.html('');

            for (var i = 0; i < items.length; i++) {
                // Correct invalid structures, e. g. child-items without direct parents
                if (i == 0) {
                    if (items[i].level > 0) {
                        items[i].level = 0;
                    }
                } else {
                    if (items[i].level - items[i - 1].level > 1) {
                        items[i].level = items[i - 1].level + 1;
                    }
                }

                var uiItem = createUiItem(items[i], i);
                $tableBody.append(uiItem);
            };

            contentify.responsiveTables();
        }

        $('#item_add').click(function()
        {
            var content = contentify.templateManager.get('itemForm',  {});

            var $footer = $('<button>').text('{{ trans('app.save') }}').click(function()
            {
                var item = {
                    title: $('#item_title').val(),
                    url: $('#item_url').val(),
                    level: 0
                };
                items.push(item);
                renderAll();
                store();
                contentify.closeModal();
            });

            contentify.modal('{{ trans('app.item') }}', content, $footer);
        });

        renderAll();
    });
</script>