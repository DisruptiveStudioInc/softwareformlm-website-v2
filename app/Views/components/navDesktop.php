<ul class="hidden lg:flex justify-end w-full grow">
<?php foreach ($navigationMenu as $item): ?>
  <li class="h-full
    <?= $item['hasSubmenu'] && !$item['isMegamenu'] ? 'relative group/submenu' : '' ?>
    <?= $item['isMegamenu'] ? 'group/submenu' : '' ?>"
  >
    <?php if(isset($item['url'])): ?>
      <a href="<?= $item['url'] ?>" class="flex items-center h-full px-3 lg:px-1.5 xl:px-3 text-sm xl:text-base text-grey-100 hover:text-brand-100 transition-colors">
        <?= $item['label'] ?>
      </a>
    <?php else: ?>
      <span class="flex items-center h-full px-3 text-sm xl:text-base group-hover/submenu:text-brand-100 transition-colors">
        <?= $item['label'] ?>
      </span>
      <ul class="absolute top-full bg-white border border-surface-300 pointer-events-none opacity-0 group-hover/submenu:opacity-100 group-hover/submenu:pointer-events-auto left-1/2 -translate-x-1/2 transition-opacity <?= $item['isMegamenu'] ? 'grid grid-cols-4 gap-x-2 gap-y-0 2xl:gap-4 w-full max-w-max p-5 rounded-2xl' : 'flex flex-col p-2 min-w-56 rounded-lg' ?>">
        <?php
          foreach($item['submenu'] as $sub):
            if($item['isMegamenu']):
        ?>
          <li class="w-full p-2.5 2xl:p-4 rounded-lg group/category hover:bg-brand-100 transition-colors">
            <h3 class="text-base 2xl:text-2xl font-bold mb-1 2xl:mb-2 text-secondary-100 group-hover/category:text-white transition-colors"><?= $sub['name'] ?></h3>
            <ul class="flex flex-col gap-0.5 2xl:gap-2 pl-2 2xl:pl-4">
              <?php foreach($sub['list'] as $subItem): ?>
                <a href="<?= $subItem['url'] ?>" class="transition-colors group-hover/category:text-white/80 hover:text-white text-sm 2xl:text-base"><?= $subItem['label'] ?></a>
              <?php endforeach; ?>
            </ul>
          </li>
        <?php else: ?>
          <li>
            <a href="<?= serviceRoute($sub['meta']['slug'], $currentLang) ?>" class="block p-2 rounded hover:bg-surface-100/80 hover:text-brand-100 transition-colors">
              <?= $sub['meta']['meta_title'] ?>
            </a>
          </li>
        <?php endif; endforeach; ?>
      </ul>
    <?php endif; ?>
  </li>
<?php endforeach; ?>
</ul>
