# IN VC Listing

## Плагин WordPress, формирующий список ветеринарных клиник
Плагин реализует функциональность для определенного сайта.
Этот плагин не претендует на глобальное распространение.

## Структура URL и шаблоны

### Клиники
Отображение списка клиник. 
Все клиники отображаются в URL ```/clinic/```, например:  
/**clinic**/my-clinic/ -- где _my-clinic_ слаг конкретной клиники.

При обращении к URL ```/clinic/``` обображается все клиники.

Для кастомизации отображегния создайте шаблоны в теме со следующими названиями:
* **single-in-vc-listing.php** -- отображение одной клиники.
* **archive-in-vc-listing.php** -- отображение списка клиник.

### Регионы
Отображение списка клиник в регионе. 
Клиники отображаются в URL ```/clinic/region/```, например:  
/clinic/**region**/my-region/ -- где _my-region_ слаг конкретного региона.

Для кастомизации отображегния создайте шаблоны в теме со следующими названиями:
* **taxonomy-in-vc-region.php** -- отображение списка клиник в регионе.

### Теги
Отображение списка клиник, помеченных определенных тегом. 
Клиники отображаются в URL ```/clinic/tag/```, например:  
/clinic/**tag**/my-tag/ -- где _my-tag_ слаг конкретного тега.

Для кастомизации отображегния создайте шаблоны в теме со следующими названиями:
* **taxonomy-in-vc-tag.php** -- отображение списка клиник, помеченных определенных тегом.

### Фильтрация тегов в регионе
Отображение списка клиник, помеченных определенных тегом в определенном регионе. 
Клиники отображаются в URL ```/clinic/filter/```, например:  
/clinic/**filter**/my-region/**tag**/my-tag/ -- где _my-region_ слаг конкретного региона,  _my-tag_ слаг конкретного тега.

Для кастомизации отображегния используется шаблон тегов:
* **taxonomy-in-vc-tag.php** -- отображение списка клиник, помеченных определенных тегом.

## FAQ
* **При обращении к списку таксономии (теги, регионы, фильтр) получаю ошибку 404**  
Необходимо обновить постоянные ссылки. Для этого зайдите в админке WordPress "Настройки --> Постоянные ссылки"
и просто нажмите кнопку "Сохранить изменения" даже если вы ничего не меняли.

## Журнал изменений
1.2 (25.05.2019)	Добавлена фильтрация по тегам внутри региона

1.1 (19.05.2019)	Добавлена таксономия регионов

1.0 (15.05.2019)	Реализация CTP и меток

