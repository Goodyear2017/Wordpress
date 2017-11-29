(function() {
    tinymce.create('tinymce.plugins.left_panel', {
        init : function(ed, url) {
            ed.addButton('left_panel', {
                title : 'Add left panel',
                image : url+'/left_panel.png',
                onclick : function() {
                     ed.selection.setContent('[left_panel]' + ed.selection.getContent() + '[/left_panel]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('left_panel', tinymce.plugins.left_panel);
})();