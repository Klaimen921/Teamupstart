<?php
$skills         = $usersData['skills'] ?? '';
$selectedSkills = explode(', ', $skills);
echo '<div class="form__skills d-flex gap-8 flex-wrap">';
$projectTypes = [
    'Mobile App Development',
    'UI/UX Design',
    'Graphic Design',
    'Digital Marketing',
    'SEO Optimization',
    'E-commerce Solutions',
    'Content Writing',
    'Data Analytics',
    'Cloud Computing',
    'Cybersecurity'
];

foreach ($projectTypes as $projectType) {
    $is_checked = in_array($projectType, $selectedSkills) ? 'checked' : '';

    echo '<div class="project-type__item">
               <input type="checkbox" name="project-type[]"
                         value="' . htmlspecialchars($projectType) . '" ' . $is_checked . '>
               <div class="project-type__btn surface-neutral">
                       <p class="body-m-regular text-on-action">' . htmlspecialchars($projectType) . '</p>
               </div>
         </div>';
}
echo '</div>';