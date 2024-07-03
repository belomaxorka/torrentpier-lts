<style>
  textarea.drag-over {
    border: dashed;
    border-radius: 5px;
  }
</style>
<script>
  (function() {
    let config = JSON.parse('{CONFIG}'),
    items = {}; $.each(config, (id, data) => { items[id] = ['TXT', data.title, data.attr1, data.attr2]; });
    TPL.el_attr = $.extend({}, items, TPL.el_attr, items);
    $.each(config, (id, data) => {
      $('body')
        .on('drop', '#' + id, (e, entries) => {
          e.preventDefault();
          let input = $('#' + id),
              pos = input.prop('selectionStart'),
              val = input.val(),
              lines = [],
              folders = new Set,
              result = {},
              scan = (entries, folder) => {
                if (folder) folders.delete(folder.fullPath);
                $.each(entries, (i, entry) => {
                  if (entry.isFile && new RegExp(data.regex || '').test(entry.name)) {
                    if (!result.hasOwnProperty(folder && folder.fullPath || '/')) result[folder && folder.fullPath || '/'] = [];
                    result[folder && folder.fullPath || '/'].push(entry);
                  } else if (entry.isDirectory) {
                    folders.add(entry.fullPath);
                    let reader = entry.createReader();
                    reader.readEntries(entries => { scan(entries, entry) });
                  }
                });
                if (!folders.size) {
                  let ordered = {};
                  Object.keys(result).sort().forEach(key => { ordered[key] = result[key]; });
                  process(ordered);
                }
              },
              process = result => {
                $.each(result, (folder, entries) => {
                  let list = [];
                  $.each(entries, (i, entry) => {
                    list.push(entry.name.replace(/\.[^/.]+$/, data.remove_extension?'':'$&'));
                  });
                  lines.push(((Object.keys(result).length > 1?data.folder_format:false) || '<<FILELIST>>').replace(/<<\w+>>/g, (txt) => new Object({
                    '<<FILELIST>>': list.join('\r\n'),
                    '<<FOLDERNAME>>': folder.replace(/^.*\/(.*)$/, '$1')
                  })[txt]));
                });
                input.val(data.insert?val.slice(0, pos) + lines.join('\r\n') + val.slice(pos):lines.join('\r\n'));
                entries || $('#' + data.duration).trigger('drop', result);
              };
            if (entries) process(entries);
            else scan($.map(e.originalEvent.dataTransfer.items, item => item.webkitGetAsEntry()));
          input.removeClass('drag-over');
        })
        .on('dragover', '#' + id, e => {
          e.preventDefault();
          $('#' + id).addClass('drag-over');
          $('#' + data.duration).addClass('drag-over');
        })
        .on('dragleave', '#' + id, 'textarea', e => {
          $('#' + id).removeClass('drag-over');
          $('#' + data.duration).removeClass('drag-over');
        });
    });
  })();
</script>
