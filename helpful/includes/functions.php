<?php

function helpful_boolval( $var ) {
    $lowercase_value = strtolower( $var );

    if ( strcmp( $lowercase_value, 'on' ) === 0 ) {
        return true;
    } else if ( strcmp( $lowercase_value, 'off' ) === 0 ) {
        return false;
    } else {
        return boolval( $var );
    }
}
