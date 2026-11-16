<?php
declare(strict_types=1);

if (!function_exists('hook_invoke_all')) {
    return;
}

function training_course_state_changed($courseId, $fromState, $toState, $meta = array()) {
    hook_invoke_all('TRAINING_STATE_CHANGED', array(
        'course_id' => $courseId,
        'from_state' => $fromState,
        'to_state' => $toState,
        'meta' => $meta,
    ));
}
