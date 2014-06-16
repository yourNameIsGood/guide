
<!--
 * Copyright (c) 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Author: Eric Bidelman <e.bidelman@chromium.org>
-->
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8 />
<link rel="stylesheet" type="text/css" href="enhanced.css" />
<!--<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Molengo|Josefin+Sans+Std+Light" />-->
<style>
html, body {
  padding: 0;
  margin: 0;
  height: 100%;
  width: 100%;
  overflow: hidden;
}
.linear {
  background: -webkit-gradient(linear, left bottom, left top,
                               from(#eee), color-stop(0.25, #fff),
                               to(#eee), color-stop(0.75, #fff));
}
.shadow {
  -moz-box-shadow: 3px 3px 10px #666666;
  -webkit-box-shadow: 3px 3px 10px #666666;
  box-shadow: 3px 3px 10px #666666;
}
.center {
  display : -webkit-box;
  display : -moz-box;
  display : box;
  -webkit-box-orient : vertical;
  -webkit-box-pack : center;
  -webkit-box-align : center;
  -moz-box-orient : vertical;
  -moz-box-pack : center;
  -moz-box-align : center;
  box-orient: vertical;
  box-pack: center;
  box-align: center;
}
::-webkit-scrollbar {
  width: 5px;
  height: 5px;
  background-color: #eee;
}

::-webkit-scrollbar-thumb {
  background-color: rgba(0,0,0, 0.4);
  border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
  background-color: rgba(0,0,0, 0.6);
}
input[type='file'] {
  border: 2px solid #eee;
  border-radius: 10px;
  padding: 8px;
  width: 93%;
}
#container {
  display: -webkit-box;
  -webkit-box-orient: horizontal;
  height: 100%;
}
#container > div {
  padding: 10px;
}
#container > div:first-of-type {
  overflow-y: auto;
  overflow-x: hidden;
  width: 300px;
  border-right: 1px solid #ccc;
}
#container > div:last-of-type {
 overflow-y: auto;
 overflow-x: hidden;
 -webkit-box-flex: 1;
}
#thumbnails {
  background: -webkit-gradient(linear, left bottom, left top,
                               from(#ccc), color-stop(0.25, #eee),
                               to(#ccc), color-stop(0.75, #eee));
  -webkit-box-shadow: inset 0 0 15px #000;
}
.thumbnail {
  /*float:left;*/
  text-align: center;
  margin-left: 10px;
  width: 450px;
  -webkit-transition-property: opacity, -webkit-transform;
  -webkit-transition-duration: 0.6s, 0.2s;
  -webkit-transition-timing-function: ease-in-out;
  opacity: 0;
}
.thumbnail:hover {
  -webkit-transform: scale(1.5);
}
.thumbnail .image {
  border: 1px solid #ccc;
  padding: 10px;
  background-color: #fff;
}
.thumbnail .title {
  margin-bottom: 5px;
  font-family: Helvetica, sans-serif;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  width: 300px;
  margin: 5px auto;
}
#thumbnails img {
  border: 1px solid #ccc;
  width: 100%;
}
.thumbnail .details {
  font-family: Helvetica, sans-serif;
  font-size: 10pt;
}
#progress_bar {
  display: none;
}
progress {
  background-color: black;
  margin: 10px 0;
  padding: 1px;
  border: 1px solid #000;
  font-size: 14px;
  width: auto;
}
progress::-webkit-progress-bar-value {
  background-color: #99ccff;
}
</style>
</head>
<body>

<div id="container">
  <div>
    <input type="file" id="file_input" webkitdirectory directory />
    <ul id="dir-tree"></ul>
  </div>
  <div class="center" id="thumbnails"></div>
</div>

<script type="text/html" id="thumbnail_template">
  <div class="thumbnail">
    <div class="image shadow">
      <img src="<%= file.src %>" alt="<%= file.name %>" title="<%= file.name %>" onload="revokeFileURL()" />
      <div class="title"><%= file.name %></div>
      <div class="details"><%= file.type %> @ <%= Math.round(file.fileSize / 1024) %> KB</div>
    </div>
  </div>
</script>
<script src="jquery.min.1.4.js" type="text/javascript"></script>
<script src="jquery.tree.js" type="text/javascript"></script>
<script>
  // Simple JavaScript Templating
  // John Resig - http://ejohn.org/ - MIT Licensed
  (function(){
    var cache = {};

    this.tmpl = function tmpl(str, data) {
      // Figure out if we're getting a template, or if we need to
      // load the template - and be sure to cache the result.
      var fn = !/\W/.test(str) ?
        cache[str] = cache[str] ||
          tmpl(document.getElementById(str).innerHTML) :

        // Generate a reusable function that will serve as a template
        // generator (and which will be cached).
        new Function("obj",
          "var p=[],print=function(){p.push.apply(p,arguments);};" +

          // Introduce the data as local variables using with(){}
          "with(obj){p.push('" +

          // Convert the template into pure JavaScript
          str
            .replace(/[\r\t\n]/g, " ")
            .split("<%").join("\t")
            .replace(/((^|%>)[^\t]*)'/g, "$1\r")
            .replace(/\t=(.*?)%>/g, "',$1,'")
            .split("\t").join("');")
            .split("%>").join("p.push('")
            .split("\r").join("\\'")
        + "');}return p.join('');");

      // Provide some basic currying to the user
      return data ? fn( data ) : fn;
    };
  })();

  window.URL = window.URL ? window.URL :
               window.webkitURL ? window.webkitURL : window;

  function Tree(selector) {
    this.$el = $(selector);
    this.fileList = [];
    var html_ = [];
    var tree_ = {};
    var pathList_ = [];
    var self = this;

    this.render = function(object) {
      if (object) {
        for (var folder in object) {
          if (!object[folder]) { // file's will have a null value
            html_.push('<li><a href="#" data-type="file">', folder, '</a></li>');
          } else {
            html_.push('<li><a href="#">', folder, '</a>');
            html_.push('<ul>');
            self.render(object[folder]);
            html_.push('</ul>');
          }
        }
      }
    };

    this.buildFromPathList = function(paths) {
      for (var i = 0, path; path = paths[i]; ++i) {
        var pathParts = path.split('/');
        var subObj = tree_;
        for (var j = 0, folderName; folderName = pathParts[j]; ++j) {
          if (!subObj[folderName]) {
            subObj[folderName] = j < pathParts.length - 1 ? {} : null;
          }
          subObj = subObj[folderName];
        }
      }
      return tree_;
    }

    this.init = function(e) {
      // Reset
      html_ = [];
      tree_ = {};
      pathList_ = [];
      self.fileList = e.target.files;

      console.log(self.fileList);

      // TODO: optimize this so we're not going through the file list twice
      // (here and in buildFromPathList).
      for (var i = 0, file; file = self.fileList[i]; ++i) {
        pathList_.push(file.webkitRelativePath);
        document.write(' <img src="'+file.webkitRelativePath+'"/>'); // write all the file on the page. no this line by default
      }

      self.render(self.buildFromPathList(pathList_));

      self.$el.html(html_.join('')).tree({
        expanded: 'li:first'
      });

      // Add full file path to each DOM element.
      var fileNodes = self.$el.get(0).querySelectorAll("[data-type='file']");
      for (var i = 0, fileNode; fileNode = fileNodes[i]; ++i) {
        fileNode.dataset['index'] = i;
      }
    }
  };

  var tree = new Tree('#dir-tree');

  $('#file_input').change(tree.init);

  // Initial resize to force scrollbar in when file loads
  $('#container div:first-of-type').css('height', (document.height - 20) + 'px');
  window.addEventListener('resize', function(e) {
    $('#container div:first-of-type').css('height', (e.target.innerHeight - 20) + 'px');
  });

  function revokeFileURL(e) {
    var thumb = document.querySelector('.thumbnail');
    if (thumb) {
      thumb.style.opacity = 1;
    }
    window.URL.revokeObjectURL(this.src);
  };

  tree.$el.click(function(e) {
    if (e.target.nodeName == 'A' && e.target.dataset['type'] == 'file') {
      var file = tree.fileList[e.target.dataset['index']];

      var thumbnails = document.querySelector('#thumbnails');

      if (!file.type.match(/image.*/)) {
        thumbnails.innerHTML = '<h3>Please select an image!</h3>';
        return;
      }

      thumbnails.innerHTML = '<h3>Loading...</h3>';

      var thumb = document.querySelector('.thumbnail');
      if (thumb) {
        thumb.style.opacity = 0;
      }

      var data = {
        'file': {
          'name': file.name,
          'src': window.URL.createObjectURL(file),
          'fileSize': file.fileSize,
          'type': file.type,
        }
      };

      // Render thumbnail template with the file info (data object).
      //thumbnails.insertAdjacentHTML('afterBegin', tmpl('thumbnail_template', data));
      thumbnails.innerHTML = tmpl('thumbnail_template', data);
    }
  });
</script>
</body>
</html>
