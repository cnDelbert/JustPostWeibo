# Just Post Weibo

You can post a text weibo via this project.

You can post a weibo with only picture and get the url addresses of the thumb, middle and origin picture.

## How to install

You should apply your own weibo app follow http://open.weibo.com/development . Then, you can get your `APP_KEY` and `APP_SECRET` here `http://open.weibo.com/webmaster/info/basic?siteid=YOUR_SITE_ID` . `CALLBACK ADDRESS` can be filled here `http://open.weibo.com/webmaster/privilege/oauth?siteid=YOUR_SITE_ID`.

Modify the file `inc/config-sample.inc.php` and rename the file to `inc/config.inc.php`.

## Customize

You can add your own HASHTAGs by modifying the file `inc/tags.inc.php`.

## Example

You may check the example [here](http://delbert.me/weibo/).

## Release Note

### v0.1.3 20150114

- [x] Change the demo address.
- [x] Copyright.
- [x] Filetype check.
- [x] File size check.
- [x] Hashtag control.
- [x] Post Tips.


### v0.1.2 20150105

- [x] Fixed texting bugs.
- [x] Privilege control.
- [x] Add more hashtags.
- [x] Modify layout.
- [x] Modify the recall message after texting only.

### v0.1.1 20150104

- [x] Upload image and post to weibo.
- [x] Basic functions.

## To-do List

- [x] Copyright.
- [x] Filetype check.
- [x] File size check.
- [x] Hashtag control.
- [x] Tips after post.

## License

Under MIT License. See [LICENSE](LICENSE) for details. 