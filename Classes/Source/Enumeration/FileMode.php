<?php

namespace Xanax\Enumeration;

abstract class FileMode
{
    const READ_ONLY = 'r';
    const READ_OVERWRITE = 'r+';
    const WRITE_ONLY = 'w';
    const READ_WRITE_TRUNCATE = 'w+';
    const APPEND_WRITE_ONLY = 'a';
    const APPEND_READ_WRITE = 'a+';
    const APPEND_BINARY_WRITE_ONLY = 'ab';
    const APPEND_BINARY_ONLY = 'ab+';
    const READ_BINARY_ONLY = 'rb';
    const READ_BINARY_TRUNCATE = 'rb+';
    const WRITE_BINARY_ONLY = 'wb';
    const WRITE_BINARY_TRUNCATE = 'wb+';
}