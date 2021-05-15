<?php


namespace App\Service\FileReader;


class TextFileReader implements FileReaderInterface
{
    private string $separator = PHP_EOL;

    /**
     * Установить разделитель строк для файла
     *
     * @param string $separator
     */
    public function setSeparator(string $separator)
    {
        $this->separator = $separator;
    }

    /**
     * Читает текстовый файл и возвращает результат в виде массива строка = количество цифр в строке
     *
     * @param string $filename
     * @return array
     */
    public function read(string $filename): array
    {
        $data = file_get_contents($filename);
        $lines = explode($this->separator, $data);

        $result = [];
        $counter = 0;

        foreach ($lines as $line) {
            $row = sprintf(
                'Строка %s = %d',
                ++$counter,
                 $this->getCountNumbers($line)
            );
            array_push($result, $row);
        }

        return $result;
    }

    /**
     * Возвращает количество цифр в строке
     *
     * @param string $line
     * @return int
     */
    private function getCountNumbers(string $line): int
    {
        preg_match_all('/\d+/', $line, $matches);
        return count($matches[0]);
    }
}
