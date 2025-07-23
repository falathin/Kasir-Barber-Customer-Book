<?php
$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';

if (file_exists($link)) {
    echo "✅ Symlink sudah ada.";
} else {
    if (symlink($target, $link)) {
        echo "✅ Symlink berhasil dibuat.";
    } else {
        echo "❌ Gagal membuat symlink.";
    }
}
