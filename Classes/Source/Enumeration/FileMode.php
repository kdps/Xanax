<?php

namespace Xanax\Enumeration;

abstract class FileMode
{
    const READ_ONLY = 'r'; // Reading from beginning of binary file
    const READ_OVERWRITE = 'r+'; // Reading and Writing from beginning of file
    const WRITE_ONLY = 'w'; // Writing file with Truncate
    const READ_WRITE_TRUNCATE = 'w+'; // Reading and Writing file with Truncate
    const APPEND_WRITE_ONLY = 'a'; // Append to the end of the file
    const APPEND_READ_WRITE = 'a+'; // Reading or Append to the end of the file
    const APPEND_BINARY_WRITE_ONLY = 'ab'; // Append to the end of the binary file
    const APPEND_BINARY_READ_WRITE_ONLY = 'ab+'; // Reading or Append to the end of the binary file
    const READ_BINARY_ONLY = 'rb'; // Reading from beginning of binary file
    const READ_BINARY_TRUNCATE = 'rb+'; // Reading and Writing from beginning of binary file
    const WRITE_BINARY_ONLY = 'wb'; // Writing binary file with Truncate
    const WRITE_BINARY_TRUNCATE = 'wb+'; // Reading and Writing binary file with Truncate
    const NEW_WRITE_ONLY = 'x';
    const NEW_READ_WRITE_ONLY = 'x+';
}