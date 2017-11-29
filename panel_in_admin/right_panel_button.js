(function() {
    tinymce.create('tinymce.plugins.right_panel', {
        init : function(ed, url) {
            ed.addButton('right_panel', {
                title : 'Add right panel',
                image : url+'/right_panel.png',
                onclick : function() {
                     ed.selection.setContent('[right_panel]' + ed.selection.getContent() + '[/right_panel]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('right_panel', tinymce.plugins.right_panel);
})();