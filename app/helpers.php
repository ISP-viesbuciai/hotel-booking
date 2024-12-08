<?php

if (!function_exists('sha256_from_scratch')) {
    function sha256_from_scratch($message) {
        // Step 1: Initialize hash values (H0 to H7)
        $H = [
            0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a,
            0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19
        ];
    
        // Step 2: Initialize round constants (K)
        $K = [
            0x428a2f98, 0x71374491, 0xb5c0fbcf, 0xe9b5dba5, 0x3956c25b, 0x59f111f1, 0x923f82a4, 0xab1c5ed5,
            0xd807aa98, 0x12835b01, 0x243185be, 0x550c7dc3, 0x72be5d74, 0x80deb1fe, 0x9bdc06a7, 0xc19bf174,
            0xe49b69c1, 0xefbe4786, 0x0fc19dc6, 0x240ca1cc, 0x2de92c6f, 0x4a7484aa, 0x5cb0a9dc, 0x76f988da,
            0x983e5152, 0xa831c66d, 0xb00327c8, 0xbf597fc7, 0xc6e00bf3, 0xd5a79147, 0x06ca6351, 0x14292967,
            0x27b70a85, 0x2e1b2138, 0x4d2c6dfc, 0x53380d13, 0x650a7354, 0x766a0abb, 0x81c2c92e, 0x92722c85,
            0xa2bfe8a1, 0xa81a664b, 0xc24b8b70, 0xc76c51a3, 0xd192e819, 0xd6990624, 0xf40e3585, 0x106aa070,
            0x19a4c116, 0x1e376c08, 0x2748774c, 0x34b0bcb5, 0x391c0cb3, 0x4ed8aa4a, 0x5b9cca4f, 0x682e6ff3,
            0x748f82ee, 0x78a5636f, 0x84c87814, 0x8cc70208, 0x90befffa, 0xa4506ceb, 0xbef9a3f7, 0xc67178f2
        ];
    
        // Step 3: Preprocess the message (pad to multiple of 512 bits)
        $message = pad_message($message);
    
        // Step 4: Process each 512-bit block
        $blocks = str_split($message, 64); // Each block is 64 bytes (512 bits)
        foreach ($blocks as $block) {
            // Prepare message schedule (64 words)
            $W = prepare_message_schedule($block);
    
            // Initialize working variables
            list($a, $b, $c, $d, $e, $f, $g, $h) = $H;
    
            // Compression function main loop (64 rounds)
            for ($t = 0; $t < 64; $t++) {
                $T1 = $h + Sigma1($e) + Ch($e, $f, $g) + $K[$t] + $W[$t];
                $T2 = Sigma0($a) + Maj($a, $b, $c);
                $h = $g;
                $g = $f;
                $f = $e;
                $e = $d + $T1;
                $d = $c;
                $c = $b;
                $b = $a;
                $a = $T1 + $T2;
            }
    
            // Add the compressed chunk to the current hash value
            $H[0] = ($H[0] + $a) & 0xFFFFFFFF;
            $H[1] = ($H[1] + $b) & 0xFFFFFFFF;
            $H[2] = ($H[2] + $c) & 0xFFFFFFFF;
            $H[3] = ($H[3] + $d) & 0xFFFFFFFF;
            $H[4] = ($H[4] + $e) & 0xFFFFFFFF;
            $H[5] = ($H[5] + $f) & 0xFFFFFFFF;
            $H[6] = ($H[6] + $g) & 0xFFFFFFFF;
            $H[7] = ($H[7] + $h) & 0xFFFFFFFF;
        }
    
        // Step 5: Produce final hash (concatenate H0 to H7)
        return implode('', array_map(fn($x) => sprintf('%08x', $x), $H));
    }
    
    // Helper functions (bitwise operations, message padding, etc.)
    function pad_message($message) {
        $bit_len = strlen($message) * 8;
        $message .= chr(0x80); // Append "1" bit followed by "0" bits
        while ((strlen($message) % 64) !== 56) {
            $message .= chr(0x00);
        }
        // Append original message length as 64-bit big-endian
        $message .= pack('N2', 0, $bit_len);
        return $message;
    }
    
    function Sigma0($x) {
        return rotate_right($x, 2) ^ rotate_right($x, 13) ^ rotate_right($x, 22);
    }
    
    function Sigma1($x) {
        return rotate_right($x, 6) ^ rotate_right($x, 11) ^ rotate_right($x, 25);
    }
    
    function Ch($x, $y, $z) {
        return ($x & $y) ^ (~$x & $z);
    }
    
    function Maj($x, $y, $z) {
        return ($x & $y) ^ ($x & $z) ^ ($y & $z);
    }
    
    function prepare_message_schedule($block) {
        $W = [];
    
        // Step 1: Split the 512-bit block into 16 words (32-bit chunks)
        for ($i = 0; $i < 16; $i++) {
            $W[$i] = unpack('N', substr($block, $i * 4, 4))[1]; // Read 4 bytes as a big-endian 32-bit integer
        }
    
        // Step 2: Extend to 64 words
        for ($t = 16; $t < 64; $t++) {
            $sigma0 = rotate_right($W[$t - 15], 7) ^ rotate_right($W[$t - 15], 18) ^ ($W[$t - 15] >> 3);
            $sigma1 = rotate_right($W[$t - 2], 17) ^ rotate_right($W[$t - 2], 19) ^ ($W[$t - 2] >> 10);
            $W[$t] = ($W[$t - 16] + $sigma0 + $W[$t - 7] + $sigma1) & 0xFFFFFFFF; // Ensure 32-bit overflow
        }
    
        return $W;
    }
    
    function rotate_right($x, $n) {
        return (($x >> $n) | ($x << (32 - $n))) & 0xFFFFFFFF; // Ensure 32-bit rotation
    }
}