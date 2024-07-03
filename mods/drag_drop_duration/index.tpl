<style>
  input.drag-over {
    border: dashed;
    border-radius: 5px;
  }
</style>
<script type="text/javascript" src="/mods/drag_drop_duration/date_format.js?v={$bb_cfg['js_ver']}"></script>
<script>
  (function() {
    let config = JSON.parse('{CONFIG}'),
    items = {}; $.each(config, (id, data) => { items[id] = ['INP', data.title, data.attr1, data.attr2]; });
    TPL.el_attr = $.extend({}, items, TPL.el_attr, items);
    $.each(config, (id, data) => {
      $('body')
        .on('drop', '#' + id, (e, entries) => {
          e.preventDefault();
          let input = $('#' + id),
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
              let duration = 0,
                  audios = new Set;
              $.each(result, (folder, entries) => {
                $.each(entries, (i, entry) => {
                  entry.file(file => {
                    let audio = new Audio(URL.createObjectURL(file));
                    audio.oncanplaythrough = () => {
                      duration += audio.duration;
                      audios.delete(audio);
                      if (!audios.size) {
                        let date = new Date(1970, 0, 1);
                        date.setSeconds(Math.round(duration));
                        input.val(date.format(data.format));
                      }
                    };
                    audios.add(audio);
                  });
                });
              });
              entries || $('#' + data.filelist).trigger('drop', result);
            };
          input.val('');
          if (entries) process(entries);
          else scan($.map(e.originalEvent.dataTransfer.items, item => item.webkitGetAsEntry()));
          input.removeClass('drag-over');
        })
        .on('dragover', '#' + id, e => {
          e.preventDefault();
          $('#' + id).addClass('drag-over');
          $('#' + data.filelist).addClass('drag-over');
        })
        .on('dragleave', '#' + id, 'textarea', e => {
          $('#' + id).removeClass('drag-over');
          $('#' + data.filelist).removeClass('drag-over');
        });
    });
  })();
</script>
