
<?php


// 1. contar_palabras($texto): Recibe una cadena de texto y devuelve el número de
// palabras en el texto.
function contar_palabras($texto) {
    return str_word_count($texto); 
}

$texto = "Panama Canal Balboa.";

$totalPalabras = contar_palabras($texto);

echo "Cadena de palabras:</br>";
echo $texto . "</br>";
echo "Total de palabras: $totalPalabras</br>";


// 2. contar_vocales($texto): Recibe una cadena de texto y devuelve el número de
// vocales (a, e, i, o, u, sin distinguir entre mayúsculas y minúsculas).
function contar_vocales($texto) {
    return preg_match_all('/[aeiouáéíóúAEIOUÁÉÍÓÚ]/', $texto);
}

$texto = "Panama Canal Cristobal.";

$totalVocales = contar_vocales($texto);

echo "Texto:</br>";
echo $texto . "</br>";
echo "Total de vocales: $totalVocales</br>";


// Llamamos a la función para invertir las palabras
function invertir_palabras($texto) {
    $palabras = explode(' ', $texto); 
    $palabras_invertidas = array_reverse($palabras); 
    return implode(' ', $palabras_invertidas); 
}

$texto = "Panama Canal";

$textoInvertido = invertir_palabras($texto);

echo "Cadena original:</br>";
echo $texto . "</br>";
echo "Palabras invertidas:</br>";
echo $textoInvertido . "</br>";

?>


