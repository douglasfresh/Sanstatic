var webPage = require('webpage');
var page = webPage.create();

page.open('http://sanstatic.com/site', function(status) {
 console.log(page.content);
  phantom.exit();
});