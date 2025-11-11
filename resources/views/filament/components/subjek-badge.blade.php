@props(['name' => '', 'color' => null]) @php $color = $color ?: '#6b7280'; //
Normalize hex $hex = ltrim($color, '#'); if (strlen($hex) === 3) { $hex =
$hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2]; } $r =
hexdec(substr($hex, 0, 2)); $g = hexdec(substr($hex, 2, 2)); $b =
hexdec(substr($hex, 4, 2)); // Perceived luminance to decide text color
$luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255; $textColor =
$luminance > 0.65 ? '#111827' : '#ffffff'; @endphp

<span
    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
    style="background-color: {{ $color }}; color: {{ $textColor }};"
>
    {{ $name }}
</span>
