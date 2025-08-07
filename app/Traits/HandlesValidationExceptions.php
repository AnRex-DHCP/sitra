<?php

namespace App\Traits;

use App\Exceptions\PermissionValidationException;

trait HandlesValidationExceptions
{
    public $errorMessage = '';

    protected function handleValidationException($exception)
    {
        if (!property_exists($this, 'errorMessage')) {
            throw new \RuntimeException('La propiedad $errorMessage debe estar definida en la clase que usa el trait HandlesValidationExceptions');
        }

        $errors = $exception->getErrors();

        // Maneja el mensaje general
        if (isset($errors['general'])) {
            $this->errorMessage = is_array($errors['general'])
                ? $errors['general'][0]
                : $errors['general'];
        } else {
            $this->errorMessage = $exception->getMessage();
        }

        // Maneja errores específicos de campo
        foreach ($errors as $field => $messages) {
            if ($field !== 'general') {
                $this->addError($field, is_array($messages) ? $messages[0] : $messages);
            }
        }
    }

    // Método auxiliar para limpiar errores
    public function clearErrors()
    {
        $this->errorMessage = '';
        $this->resetValidation();
    }

    // Hook para Livewire que limpia los errores al actualizar cualquier propiedad
    public function updated($propertyName)
    {
        $this->clearErrors();
        $this->validateOnly($propertyName);
    }
}
