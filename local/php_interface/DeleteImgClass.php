<?
// определяем пространство имен
namespace img;
// подключаем пролог битрикс
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
class DeleteImgClass
{
    // удалять ли найденые файлы yes/no, если выбран yes можно выбрать создовать ли копию. Если варан no, бекап автоматически создастся но файлы из /upload/ не будут удалятся
    public $deleteFiles = 'yes';
    // создавать ли бэкап файла yes/no
    public $saveBackup = 'no';
    // папка для бэкапа
    public $patchBackup;
    // целевая папка для поиска файлов
    public $rootDirPath;
    // файл для записи данных
    public $file;
    // массив для записи файлов из таблицы b_file
    public $arFilesCache = array();
    function __construct()
    {
        // глобальный объект $DB для работы с базой данных
        global $DB;
        // запрет на сбор статистики по данной странице
        define("NO_KEEP_STATISTIC", true);
        // отключаем проверку прав на доступ к файлам и каталогам
        define("NOT_CHECK_PERMISSIONS", true);
        // папка для бэкапа
        $this->patchBackup = $_SERVER['DOCUMENT_ROOT'] . "/upload/iblock_Backup/";
        // целевая папка для поиска файлов
        $this->rootDirPath = $_SERVER['DOCUMENT_ROOT'] . "/upload/iblock";
        // создаем пустой файл
        file_put_contents($this->file = $this->patchBackup . date('H.i.s_d.m.Y') . '.txt', '');
        // вызываем метод создания папки для бекапа
        $this->DirPatchBackup();
        // вызываем метод создания массива с файлами из базы
        $this->ArFiles();
        // вызываем метод создания пути
        $this->Path();
    }
    // cоздание папки для бэкапа
    function DirPatchBackup()
    {
        if (!file_exists($this->patchBackup)) {
            CheckDirPath($this->patchBackup);
        }
    }
    // запись файлов в массив из базы
    function ArFiles()
    {
        // глобальный объект $DB для работы с базой данных
        global $DB;
        // получаем записи из таблицы b_file
        $result = $DB->Query('SELECT FILE_NAME, SUBDIR FROM b_file WHERE MODULE_ID = "iblock"');
        // перебираем записи из таблицы b_file
        while ($row = $result->Fetch()) {
            $this->arFilesCache[$row['FILE_NAME']] = $row['SUBDIR'];
        }

    }
    // получение пути
    function Path()
    {
        // открываем целевую папку с файлами /upload/iblock
        $rootDir = opendir($this->rootDirPath);
        // запускаем цикл и получает элемент подкатигории по его дескриптору из папки /upload/iblock
        while (false !== ($subDirName = readdir($rootDir))) {
            // проверяем на точку и прирываем итерацию, в каталоге самая первая запись всегда точка, вторая две точки, после этого идут подпапки и файлы
            if ($subDirName == '.' || $subDirName == '..') {
                continue;
            }
            // путь до подкатегории /upload/iblock/..
            $subDirPath = "$this->rootDirPath/$subDirName";
            // открываем папку подкатигории /upload/iblock/..
            $subDir = opendir($subDirPath);
            // запускаем цикл и получает элемент подкатигории по его дескриптору из папки /upload/iblock/..
            while (false !== ($subFileName = readdir($subDir))) {
                // проверяем на точку и прирываем итерацию, в каталоге самая первая запись всегда точка, вторая две точки, после этого идут подпапки и файлы
                if ($subFileName == '.' || $subFileName == '..') {
                    continue;
                }
                // путь до подкатегории или файла /upload/iblock/../..
                $subFilePath = "$this->rootDirPath/$subDirName/$subFileName";
                // проверяем на директорию/файл и вызываем соответствующий метод
                if (is_dir($subFilePath)) {
                    $this->TwoDir($subFilePath, $subDirName, $subFileName, $subDirPath);
                } else {
                    $this->OneDir($subDirPath, $subFileName, $subDirName);
                }
            }
        }
        // закрываем целевую папку с файлами /upload/iblock
        closedir($rootDir);
    }
    function OneDir($subDirPath, $fileName, $subDirName)
    {
        // пометка для файла
        $filesCount = 0;
        // если файл с диска есть в списке файлов базы, значит пропуск
        if (array_key_exists($fileName, $this->arFilesCache)) {
            // увеличиваем счетчик нужных файлов
            $filesCount++;
        }
print_r(array_key_exists($fileName, $this->arFilesCache));

        // полный путь до файла
        $fullPath = "$subDirPath/$fileName";
        // переменная сигнализирующая о наличии поддириктории
        $backTrue = false;
        // если задано удаление найденных файлов и найденный файл не нужный
        if ($this->deleteFiles === 'yes' && $filesCount == 0) {
            // если задано делать бекап, делаем
            if ($this->saveBackup === 'yes') {
                // проверяем наличие поддиректории в папке для бекапа /upload/iblock_Backup/
                if (!file_exists($this->patchBackup . $subDirName)) {
                    // если в папке для бекапов /upload/iblock_Backup/ нет поддириктории, создаем ее 
                    if (CheckDirPath($this->patchBackup . $subDirName)) {
                        // меняем переменную сигнализирующая о наличии поддириктории
                        $backTrue = true;
                    }
                } else {
                    // меняем переменную сигнализирующая о наличии поддириктории
                    $backTrue = true;
                }
                // если поддириктория есть
                if ($backTrue) {
                    // создаем копию в бэкап
                    CopyDirFiles($fullPath, $this->patchBackup . $subDirName . '/' . $fileName);
                }
            }
            // метод записи в информационный файл
            $this->Fputs('Файл удален: ', $fullPath);
            // удаление файла
            unlink($fullPath);
            // удаление поддириктории
            rmdir($subDirPath);
        }
        // если задано не удаление найденных файлов и найденный файл не нужный
        if ($this->deleteFiles === 'no' && $filesCount == 0) {
            // проверяем наличие поддиректории в папке для бекапа /upload/iblock_Backup/
            if (!file_exists($this->patchBackup . $subDirName)) {
                // если в папке для бекапов /upload/iblock_Backup/ нет поддириктории, создаем ее 
                if (CheckDirPath($this->patchBackup . $subDirName)) {
                    // меняем переменную сигнализирующая о наличии поддириктории
                    $backTrue = true;
                }
            } else {
                // меняем переменную сигнализирующая о наличии поддириктории
                $backTrue = true;
            }
            // если поддириктория есть
            if ($backTrue) {
                // создаем копию в бэкап
                CopyDirFiles($fullPath, $this->patchBackup . $subDirName . '/' . $fileName);
            }
            // метод записи в информационный файл
            $this->Fputs('Файл не удален и скопирован: ', $fullPath);
        }
    }
    function TwoDir($subSubDirPath, $subDirName, $subFileName, $subDirPath)
    {
        // пометка для файла
        $filesCount = 0;
        // открываем папку с файлом
        $hSubDir = opendir($subSubDirPath);
        // запускаем цикл и получает уже элемент по его дескриптору из подкатигории /upload/iblock/../..
        while (false !== ($fileName = readdir($hSubDir))) {
            // проверяем на точку и прирываем итерацию, в каталоге самая первая запись всегда точка, вторая две точки, после этого идут подпапки и файлы
            if ($fileName == '.' || $fileName == '..') {
                continue;
            }
            // если файл с диска есть в списке файлов базы, значит пропуск
            if (array_key_exists($fileName, $this->arFilesCache)) {
                // увеличиваем счетчик нужных файлов
                $filesCount++;
                continue;
            }
            // полный путь до файла
            $fullPath = "$subSubDirPath/$fileName";
            // переменная сигнализирующая о наличии поддириктории
            $backTrue = false;
            // если задано удаление найденных файлов
            if ($this->deleteFiles === 'yes') {
                // проверяем наличие поддиректории в папке для бекапа /upload/iblock_Backup/
                if (!file_exists($this->patchBackup . $subDirName . '/' . $subFileName . '/')) {
                    // если в папке для бекапов /upload/iblock_Backup/ нет поддириктории, создаем ее 
                    if (CheckDirPath($this->patchBackup . $subDirName . '/' . $subFileName . '/')) {
                        // меняем переменную сигнализирующая о наличии поддириктории
                        $backTrue = true;
                    }
                } else {
                    // меняем переменную сигнализирующая о наличии поддириктории
                    $backTrue = true;
                }
                // если поддириктория есть и нужно создавать бекап файла
                if ($backTrue && $this->saveBackup === 'yes') {
                    // создаем копию в бэкап
                    CopyDirFiles($fullPath, $this->patchBackup . $subDirName . '/' . $subFileName . '/' . $fileName);
                }
                // метод записи в информационный файл
                $this->Fputs('Файл удален: ', $fullPath);
                // удаление файла
                unlink($fullPath);
                // удаление поддиректории, если каталог пуст
                if ($this->deleteFiles === 'yes' && $filesCount == 0) {
                    rmdir($subSubDirPath);
                    rmdir($subDirPath);
                }
            }
            // если задано не удаление найденных файлов
            if ($this->deleteFiles === 'no') {
                // проверяем наличие поддиректории в папке для бекапа /upload/iblock_Backup/
                if (!file_exists($this->patchBackup . $subDirName . '/' . $subFileName . '/')) {
                    // если в папке для бекапов /upload/iblock_Backup/ нет поддириктории, создаем ее 
                    if (CheckDirPath($this->patchBackup . $subDirName . '/' . $subFileName . '/')) {
                        // меняем переменную сигнализирующая о наличии поддириктории
                        $backTrue = true;
                    }
                } else {
                    // меняем переменную сигнализирующая о наличии поддириктории
                    $backTrue = true;
                }
                // если поддириктория есть
                if ($backTrue) {
                    // создаем копию в бэкап
                    CopyDirFiles($fullPath, $this->patchBackup . $subDirName . '/' . $subFileName . '/' . $fileName);
                }
                // метод записи в информационный файл
                $this->Fputs('Файл не удален и скопирован: ', $fullPath);
            }
            // удаляем переменные
            unset($fileName, $backTrue);
        }
        // закрываем папку подкатигории
        closedir($hSubDir);
    }
    function Fputs($name, $path)
    {
        // открываем информационный файл
        $fd = fopen($this->file, 'a');
        // записываем в информационный файл
        fputs($fd, $name . $path . "\n");
        // закрываем информационный файл
        fclose($fd);
    }
}