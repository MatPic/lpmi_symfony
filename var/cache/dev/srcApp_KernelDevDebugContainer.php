<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerTnIpxri\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerTnIpxri/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerTnIpxri.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerTnIpxri\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerTnIpxri\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'TnIpxri',
    'container.build_id' => 'ff34f6a1',
    'container.build_time' => 1610117327,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerTnIpxri');