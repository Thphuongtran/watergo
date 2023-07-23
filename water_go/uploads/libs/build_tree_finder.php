<?php


use Symfony\Component\Finder\Finder;

// $folderPath = THEME_DIR . '/uploads';
function buildTree($directoryPath) {
   $tree = [];

   $finder = new Finder();
   $finder->in($directoryPath);
   // foreach ($finder->directories() as $subDirectory) {
   //    $subDirectoryPath = $subDirectory->getRealPath();
   //    $tree[] = [
   //       'name' => basename($subDirectoryPath),
   //       'type' => 'directory',
   //       'children' => buildTree($subDirectoryPath),
   //    ];
   // }

   foreach ($finder->files() as $file) {
      $explodePath = explode('uploads', $file->getRealPath());
      $uri = get_template_directory_uri() . '/uploads' . $explodePath[1];
      $tree[] = [
         'uri'  => $uri,
         'url'  => $file->getRealPath(),
         'name' => $file->getFilename(),
         'type' => 'file',
         'extension' => $file->getExtension(),
         // 'size' => round($fileSizeInBytes / 1024, 2) $file->getSize(),
         'size' => round($file->getSize() / 1024, 2) . ' KB',
         'date' => date('Y-m-d H:i:s', $file->getMTime())
      ];
   }

   return $tree;
}
