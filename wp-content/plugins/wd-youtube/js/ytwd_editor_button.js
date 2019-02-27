(function () {
  tinymce.create('tinymce.plugins.ytwd_mce', {
    init:function (ed, url) {
      var c = this;
      c.url = url;
      c.editor = ed;
      ed.addCommand('mceytwd_mce', function () {
        ed.windowManager.open({
          file:ytwd_admin_ajax,
          width:1000 + ed.getLang('ytwd_mce.delta_width', 0),
          height:400 + ed.getLang('ytwd_mce.delta_height', 0),
          inline:1
        }, {
          plugin_url:url
        });
        var e = ed.selection.getNode(), d = wp.media.gallery, f;
        if (typeof wp === "undefined" || !wp.media || !wp.media.gallery) {
          return
        }
        if (e.nodeName != "IMG" || ed.dom.getAttrib(e, "class").indexOf("ytwd_shortcode") == -1) {
          return
        }
        f = d.edit("[" + ed.dom.getAttrib(e, "title") + "]");
      });
      ed.addButton('ytwd_mce', {
        title:'Insert YouTube WD',
        cmd:'mceytwd_mce',
        image: url + '/icon-yt-20.png'
      });
      ed.onMouseDown.add(function (d, f) {
        if (f.target.nodeName == "IMG" && d.dom.hasClass(f.target, "ytwd_shortcode")) {
          var g = tinymce.activeEditor;
          g.wpGalleryBookmark = g.selection.getBookmark("simple");
          g.execCommand("mceytwd_mce");
        }
      });
      ed.onBeforeSetContent.add(function (d, e) {
        e.content = c._do_ytwd(e.content)
      });
      ed.onPostProcess.add(function (d, e) {
        if (e.get) {
          e.content = c._get_ytwd(e.content)
        }
      })
    },
    _do_ytwd:function (ed) {
      return ed.replace(/\[YouTube_WD([^\]]*)\]/g, function (d, c) {
                        
        return '<img src="' + ytwd_plugin_url +'/assets/icon-yt-50.png" class="ytwd_shortcode mceItem" title="YouTube_WD' + tinymce.DOM.encode(c) + '" alt="YouTube_WD' + tinymce.DOM.encode(c) + '" />';
      })
    },
    _get_ytwd:function (b) {
      function ed(c, d) {
        d = new RegExp(d + '="([^"]+)"', "g").exec(c);
        return d ? tinymce.DOM.decode(d[1]) : "";
      }

      return b.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function (e, d) {
        var c = ed(d, "class");
        if (c.indexOf("ytwd_shortcode") != -1) {
          return "<p>[" + tinymce.trim(ed(d, "title")) + "]</p>"
        }
        return e
      })
    }
  });
  tinymce.PluginManager.add('ytwd_mce', tinymce.plugins.ytwd_mce);
})();