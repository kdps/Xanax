<?php

declare(strict_types=1);

namespace Xanax\Classes\Compression;

use Xanax\Enumeration\FileMode;

class Zip
{
	public function getCompressSize($filePath)
	{
		$zip = new \ZipArchive();
		if ($zip->open($filePath) === true)
		{
			$totalSize = 0;
			for ($i = 0; $i < $zip->numFiles; $i++)
			{
				$fileStats = $zip->statIndex($i);
				$totalSize += $fileStats['size'];
			}

			$results = filesize($filePath);
			$zip->close();

			return $results;
		}
	}

	public function getRequireSize($filePath)
	{
		$zip = new \ZipArchive();
		if ($zip->open($filePath) === true)
		{
			$totalSize = 0;
			for ($i = 0; $i < $zip->numFiles; $i++)
			{
				$fileStats = $zip->statIndex($i);
				$totalSize += $fileStats['size'];
			}

			$results = round(($totalSize - filesize($filePath)), -4);
			$zip->close();

			return $results;
		}
	}

	public function Uncompress($filePath)
	{
		$zip = zip_open($filePath);

		while ($zip_entry = zip_read($zip))
		{
			if (!zip_entry_open($zip, $zip_entry, FileMode::READ_ONLY))
			{
				return false;
			}

			$zdir = dirname(zip_entry_name($zip_entry));
			if (!is_dir($zdir))
			{
				mkdir($zdir, 0777);
			}

			$zip_fs = zip_entry_filesize($zip_entry);
			if (empty($zip_fs))
			{
				continue;
			}

			$zname = zip_entry_name($zip_entry);
			$z = fopen($zname, FileMode::WRITE_ONLY);
			$zz = zip_entry_read($zip_entry, $zip_fs);
			fwrite($z, $zz);
			fclose($z);
			zip_entry_close($zip_entry);
		}

		zip_close($zip);
	}

	public function Compress($filePath, array $fileList)
	{
		$zipHandler = new \ZipArchive();

		if ($zipHandler->open($filePath, \ZipArchive::CREATE) !== true)
		{
			return false;
		}

		foreach ($fileList as $key => $val)
		{
			if (file_exists($val['filepath']))
			{
				$zipHandler->addFile($val['filepath'], $val['filename']);
			}
			else
			{
				continue;
			}
		}

		$zipHandler->close();
	}
}
