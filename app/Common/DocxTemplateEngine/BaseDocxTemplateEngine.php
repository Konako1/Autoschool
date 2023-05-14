<?php

namespace App\Common\DocxTemplateEngine;

use App\Common\Exceptions\ValidationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use PhpDocxTemplate\PhpDocxTemplate;

abstract class BaseDocxTemplateEngine
{
    /**
     * @var string
     */
    protected $templateType;

    /**
     * @var string
     */
    protected $templatePath;

    protected static $dataKeys;

    /**
     * @throws FileNotFoundException
     */
    protected function __construct(string $templateType, string $templateFileName) {
        $this->createTemplatesDirectoryIfNotExists();
        $this->setTemplatePath($this->templatesDirectory() . DIRECTORY_SEPARATOR . $templateFileName);
        $this->setTemplateType($templateType);
    }

    /**
     * @return array Saved document data
     * @throws ValidationException
     *
     */
    protected function saveDocument(array $data): array
    {
        $isDataValid = $this->validateDataArray($data, static::$dataKeys);
        if (!$isDataValid) {
            throw new ValidationException("Данные для шаблона $this->templateType не прошли валидацию.");
        }

        $time = time();
        $docName = "{$this->templateType}_$time.docx";
        $pathToSave = $this->savingDirectory() . DIRECTORY_SEPARATOR . $docName;
        $docx = new PhpDocxTemplate($this->templatePath);
        $docx->render($data);
        $docx->save($pathToSave);

        return [
            'name' => $docName,
            'path' => $pathToSave,
            'type' => $this->templateType
        ];
    }

    protected function validateDataArray(array $data, array $keys): bool
    {
        $notCheckedKeys = $keys;
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $keys))
                return false;

            // recursive check when value of key is array
            if (is_array($value)) {
                if (array_key_exists('*', $keys[$key])) {
                    foreach ($value as $vKey => $vValue) {
                        $isValid = $this->validateDataArray($vValue, $keys[$key]['*']);
                        if (!$isValid)
                            return false;
                    }
                }
                else {
                    $isValid = $this->validateDataArray($value, $keys[$key]);
                    if (!$isValid)
                        return false;
                }
            }

            unset($notCheckedKeys[$key]);
        }

        if (!empty($notCheckedKeys))
            return false;
        return true;
    }

    private function savingDirectory(): string {
        $documentsDir = base_path() . DIRECTORY_SEPARATOR . 'public' .
            DIRECTORY_SEPARATOR . 'documents';
        if (!is_dir($documentsDir)) {
            mkdir($documentsDir);
        }

        $dir = $documentsDir . DIRECTORY_SEPARATOR . $this->templateType;
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        return $dir;
    }

    protected function templatesDirectory(): string {
        return base_path() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'templates';
    }

    /**
     * @throws FileNotFoundException
     */
    private function setTemplatePath(string $pathToFile) {
        if (!is_file($pathToFile))
            throw new FileNotFoundException();
        $this->templatePath = $pathToFile;
    }

    private function setTemplateType(string $type) {
        $this->templateType = $type;
    }

    private function createTemplatesDirectoryIfNotExists() {
        if (!is_dir(base_path() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'templates')) {
            mkdir(base_path() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'templates');
        }
    }
}
