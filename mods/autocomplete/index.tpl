<script type="text/javascript" src="{SITE_URL}mods/autocomplete/jquery-ui.min.js?v={$bb_cfg['js_ver']}"></script>
<link rel="stylesheet" href="{SITE_URL}mods/autocomplete/jquery-ui.min.css?v={$bb_cfg['css_ver']}" type="text/css">
<script>
  (function() {
    let config = JSON.parse('{CONFIG}'),
    items = {}; $.each(config, (id, data) => { items[id] = ['INP', data.title, data.attr1, data.attr2]; });
    TPL.el_attr = $.extend({}, items, TPL.el_attr, items);
    $.each(config, (id, data) => {
      let input = $('#' + id),
        multi = data.multiple;
      $('body').on('DOMNodeInserted', e => {
        let input = $(e.target).find('#' + id);
        input
          .on('keydown', event => {
            if (event.keyCode === $.ui.keyCode.TAB && input.autocomplete('instance').menu.active) {
              event.preventDefault();
            }
          })
          .on('focus', e => {
            input.keydown();
          })
          .on('blur', e => {
            input.val(input.val().replace(/,\s*$/, ''))
          })
          .autocomplete({
            minLength: 0,
            source: (request, response) => {
              let options = multi?$(data.options).not(request.term.split(/,\s*/)).get().sort():data.options.sort(),
                term = multi?request.term.split(/,\s*/).pop():request.term;
              response($.ui.autocomplete.filter(options, term));
            },
            focus: () => { return false; },
            select: (event, ui) => {
              let terms = input.val().split(/,\s*/);
              terms.pop();
              terms.push(ui.item.value);
              if (multi) terms.push('');
              input.val(terms.join(', '));
              if (multi) input.keydown();
              return false;
            }
          });
      });
    });
  })();
</script>
