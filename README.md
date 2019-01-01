# Letter Avatar for PHP

Generate user avatar using name initials letter.

![letter-avatar](https://cloud.githubusercontent.com/assets/618412/12192012/835c7488-b60d-11e5-9276-d06f42d11a86.png)

## Features
* Data URI image ready (also save as PNG/JPG).
* Consistent color.
* Customize size, shape: square, circle.
* Small, fast.

## Install

Via Composer

``` bash
$ composer require yohang88/letter-avatar
```

### Implementation

``` php
<?php

use filsh\LetterAvatar\LetterAvatar;

$avatar = new LetterAvatar('Steven Spielberg');

// Square Shape, Size 64px
$avatar = new LetterAvatar('Steven Spielberg', 'square', 64);

// Save Image As PNG/JPEG
$avatar->saveAs('path/to/filename');
$avatar->saveAs('path/to/filename', LetterAvatar::MIME_TYPE_JPEG);

// Own Color Provider
$colorProvider = new \filsh\LetterAvatar\RandomColorProvider(1.3);
// or
$colorProvider = new \filsh\LetterAvatar\ColorPaletteProvider([
    "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
    "#f1c40f", "#e67e22", "#e74c3c", "#a5a8a8", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d",
]);

$avatar = new LetterAvatar('Steven Spielberg', 'square', 64, $colorProvider);

```

``` html
<img src="<?php echo $avatar ?>" />
```
