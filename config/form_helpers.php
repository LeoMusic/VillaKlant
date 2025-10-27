<?php
/**
 * Form Helpers - Standaard methoden voor formulier elementen
 * 
 * Deze klasse biedt gestandaardiseerde methoden om formulier elementen te maken
 * met consistente styling en verplichte veld indicaties.
 */

class FormHelpers {
    
    /**
     * Maakt een label met optionele verplichte veld indicatie
     * 
     * @param string $for Het ID van het gekoppelde input element
     * @param string $text De labeltekst
     * @param bool $required Of het veld verplicht is
     * @param string $additionalClasses Extra CSS klassen
     * @return string HTML voor het label
     */
    public static function createLabel($for, $text, $required = false, $additionalClasses = '') {
        $classes = 'form-label ' . $additionalClasses;
        $requiredIndicator = $required ? ' <span class="text-danger required-indicator">*</span>' : '';
        
        return '<label for="' . htmlspecialchars($for) . '" class="' . trim($classes) . '">' . 
               htmlspecialchars($text) . $requiredIndicator . '</label>';
    }
    
    /**
     * Maakt een text input veld met label
     * 
     * @param string $name De naam van het input veld
     * @param string $label De labeltekst
     * @param bool $required Of het veld verplicht is
     * @param string $value De waarde van het veld (voor edit formulieren)
     * @param string $placeholder Placeholder tekst
     * @param string $additionalClasses Extra CSS klassen voor het input veld
     * @return string HTML voor het complete input veld met label
     */
    public static function createTextInput($name, $label, $required = false, $value = '', $placeholder = '', $additionalClasses = '') {
        $classes = 'form-control ' . $additionalClasses;
        $requiredAttr = $required ? ' required' : '';
        $placeholderAttr = $placeholder ? ' placeholder="' . htmlspecialchars($placeholder) . '"' : '';
        $valueAttr = $value ? ' value="' . htmlspecialchars($value) . '"' : '';
        
        $html = '<div class="mb-3">';
        $html .= self::createLabel($name, $label, $required);
        $html .= '<input type="text" class="' . trim($classes) . '" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '"' . 
                 $valueAttr . $placeholderAttr . $requiredAttr . '>';
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Maakt een textarea veld met label
     * 
     * @param string $name De naam van het textarea veld
     * @param string $label De labeltekst
     * @param bool $required Of het veld verplicht is
     * @param string $value De waarde van het veld
     * @param int $rows Aantal rijen
     * @param string $placeholder Placeholder tekst
     * @param string $additionalClasses Extra CSS klassen
     * @return string HTML voor het complete textarea veld met label
     */
    public static function createTextarea($name, $label, $required = false, $value = '', $rows = 3, $placeholder = '', $additionalClasses = '') {
        $classes = 'form-control ' . $additionalClasses;
        $requiredAttr = $required ? ' required' : '';
        $placeholderAttr = $placeholder ? ' placeholder="' . htmlspecialchars($placeholder) . '"' : '';
        
        $html = '<div class="mb-3">';
        $html .= self::createLabel($name, $label, $required);
        $html .= '<textarea class="' . trim($classes) . '" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" rows="' . $rows . '"' . 
                 $placeholderAttr . $requiredAttr . '>' . htmlspecialchars($value) . '</textarea>';
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Maakt een select dropdown met label
     * 
     * @param string $name De naam van het select veld
     * @param string $label De labeltekst
     * @param array $options Array van opties (value => text)
     * @param bool $required Of het veld verplicht is
     * @param string $selectedValue De geselecteerde waarde
     * @param string $defaultText Standaard optie tekst
     * @param string $additionalClasses Extra CSS klassen
     * @return string HTML voor het complete select veld met label
     */
    public static function createSelect($name, $label, $options, $required = false, $selectedValue = '', $defaultText = 'Selecteer een optie', $additionalClasses = '') {
        $classes = 'form-control ' . $additionalClasses;
        $requiredAttr = $required ? ' required' : '';
        
        $html = '<div class="mb-3">';
        $html .= self::createLabel($name, $label, $required);
        $html .= '<select class="' . trim($classes) . '" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '"' . $requiredAttr . '>';
        
        if ($defaultText) {
            $html .= '<option value="">' . htmlspecialchars($defaultText) . '</option>';
        }
        
        foreach ($options as $value => $text) {
            $selected = ($value == $selectedValue) ? ' selected' : '';
            $html .= '<option value="' . htmlspecialchars($value) . '"' . $selected . '>' . htmlspecialchars($text) . '</option>';
        }
        
        $html .= '</select>';
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Maakt een email input veld met label
     * 
     * @param string $name De naam van het input veld
     * @param string $label De labeltekst
     * @param bool $required Of het veld verplicht is
     * @param string $value De waarde van het veld
     * @param string $placeholder Placeholder tekst
     * @param string $additionalClasses Extra CSS klassen
     * @return string HTML voor het complete email input veld met label
     */
    public static function createEmailInput($name, $label, $required = false, $value = '', $placeholder = '', $additionalClasses = '') {
        $classes = 'form-control ' . $additionalClasses;
        $requiredAttr = $required ? ' required' : '';
        $placeholderAttr = $placeholder ? ' placeholder="' . htmlspecialchars($placeholder) . '"' : '';
        $valueAttr = $value ? ' value="' . htmlspecialchars($value) . '"' : '';
        
        $html = '<div class="mb-3">';
        $html .= self::createLabel($name, $label, $required);
        $html .= '<input type="email" class="' . trim($classes) . '" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '"' . 
                 $valueAttr . $placeholderAttr . $requiredAttr . '>';
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Maakt een URL input veld met label
     * 
     * @param string $name De naam van het input veld
     * @param string $label De labeltekst
     * @param bool $required Of het veld verplicht is
     * @param string $value De waarde van het veld
     * @param string $placeholder Placeholder tekst
     * @param string $additionalClasses Extra CSS klassen
     * @return string HTML voor het complete URL input veld met label
     */
    public static function createUrlInput($name, $label, $required = false, $value = '', $placeholder = '', $additionalClasses = '') {
        $classes = 'form-control ' . $additionalClasses;
        $requiredAttr = $required ? ' required' : '';
        $placeholderAttr = $placeholder ? ' placeholder="' . htmlspecialchars($placeholder) . '"' : '';
        $valueAttr = $value ? ' value="' . htmlspecialchars($value) . '"' : '';
        
        $html = '<div class="mb-3">';
        $html .= self::createLabel($name, $label, $required);
        $html .= '<input type="url" class="' . trim($classes) . '" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '"' . 
                 $valueAttr . $placeholderAttr . $requiredAttr . '>';
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Maakt een telefoon input veld met label
     * 
     * @param string $name De naam van het input veld
     * @param string $label De labeltekst
     * @param bool $required Of het veld verplicht is
     * @param string $value De waarde van het veld
     * @param string $placeholder Placeholder tekst
     * @param string $additionalClasses Extra CSS klassen
     * @return string HTML voor het complete telefoon input veld met label
     */
    public static function createTelInput($name, $label, $required = false, $value = '', $placeholder = '', $additionalClasses = '') {
        $classes = 'form-control ' . $additionalClasses;
        $requiredAttr = $required ? ' required' : '';
        $placeholderAttr = $placeholder ? ' placeholder="' . htmlspecialchars($placeholder) . '"' : '';
        $valueAttr = $value ? ' value="' . htmlspecialchars($value) . '"' : '';
        
        $html = '<div class="mb-3">';
        $html .= self::createLabel($name, $label, $required);
        $html .= '<input type="tel" class="' . trim($classes) . '" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '"' . 
                 $valueAttr . $placeholderAttr . $requiredAttr . '>';
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Voegt CSS toe voor verplichte veld styling
     * 
     * @return string CSS styling voor verplichte velden
     */
    public static function getRequiredFieldsCSS() {
        return '
        <style>
        .required-indicator {
            color: #dc3545 !important;
            font-weight: bold;
            margin-left: 2px;
        }
        
        .form-control:required {
            border-left: 3px solid #dc3545;
        }
        
        .form-control:required:valid {
            border-left: 3px solid #28a745;
        }
        
        .form-control:focus:required {
            border-left: 3px solid #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        /* Tooltip voor verplichte velden */
        .required-field-info {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        /* Styling voor error states */
        .is-invalid {
            border-left: 3px solid #dc3545 !important;
        }
        
        .invalid-feedback {
            display: block;
            font-size: 0.875em;
            color: #dc3545;
            margin-top: 0.25rem;
        }
        </style>';
    }
    
    /**
     * Maakt een informatief blok over verplichte velden
     * 
     * @return string HTML voor informatief blok
     */
    public static function createRequiredFieldsInfo() {
        return '
        <div class="alert alert-info" role="alert">
            <small><strong>Let op:</strong> Velden gemarkeerd met een <span class="text-danger">*</span> zijn verplicht om in te vullen.</small>
        </div>';
    }
}
?>