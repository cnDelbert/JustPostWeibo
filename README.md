# Just Post Weibo

You can post a text weibo via this project.

You can post a weibo with only picture and get the url addresses of the thumb, middle and origin picture.

## How to install

You should apply your own weibo app follow http://open.weibo.com/development . Then, you can get your `APP_KEY` and `APP_SECRET` here `http://open.weibo.com/webmaster/info/basic?siteid=YOUR_SITE_ID` . `CALLBACK ADDRESS` can be filled here `http://open.weibo.com/webmaster/privilege/oauth?siteid=YOUR_SITE_ID`.

Modify the file `inc/config-sample.inc.php` and rename the file to `inc/config.inc.php`.

## Customize

You can add your own HASHTAG by modifying the file `inc/tags.inc.php`.

## Example

You may check the example [here](http://zhnpng.com/wb/).

## Release Note

### v0.1.2 20150105

- Fixed texting bugs.
- Privilege control.
- Add more hashtags.
- Modify layout.
- Modify the recall message after texting only.

### v0.1.1 20150104

- Upload image and post to weibo.
- Basic functions.

## To-do List

[ ] Copyright.
[ ] Filetype check.
[ ] File size check.
[ ] Hashtag control.

## License

Under MIT License. See [LICENSE](LICENSE) for details. 