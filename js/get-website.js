var webPage = require('webpage');
var page = webPage.create();

page.open('http://google.com/', function(status) {
 console.log(page.content);
  phantom.exit();
});