![Logo](styles/images/logo/logo.png)

<hr>

TorrentPier II - движок торрент-трекера, написанный на php. Высокая скорость работы, простота модификации, устойчивость к высоким нагрузкам, в том числе и поддержка альтернативных анонсеров (например, Ocelot). Помимо этого, крайне развитый официальный форум поддержки, где помимо прочего можно испытать движок в работе на демо-версии, не устанавливая его, а также получить любую другую интересующую вас информацию и скачать моды.

Основа для LTS версии: [v2.1.5-ALPHA5](https://github.com/torrentpier/torrentpier/releases/tag/v2.1.5).

<hr>

> Подробнее про LTS версию: https://torrentpier.com/threads/predstavlenie-torrentpier-lts.42114/

> Список изменений: [CHANGELOG.md](https://github.com/torrentpier/torrentpier-lts/blob/main/CHANGELOG.md)

## 🚧️ Предупреждение

Настоятельно рекомендуется использовать движок со стандартным шаблоном, поскольку в tpl файлах тоже есть фиксы, которых может не быть в готовых шаблонах (сторонних). В любом случае вы можете интегрировать нужные исправления самостоятельно в сторонний шаблон. Для этого нужно воспользоваться историей коммитов папки [templates](https://github.com/torrentpier/torrentpier-lts/commits/main/styles/templates).
<br><br><i>P.S. - Историю коммитов нужно смотреть с самого начала (снизу).</i>

## 💾 Установка

Для установки вам необходимо выполнить несколько простых шагов:

1. Распаковываем на сервер содержимое скачанной вами папки

2. Создаем базу данных, в которую при помощи phpmyadmin (или любого другого удобного инструмента) импортируем дамп, расположенный в папке **install/sql/mysql.sql**
3. Правим файл конфигурации **library/config.php**, загруженный на сервер:
 * ***'db1' => array('localhost:3306', 'tp_215_lts', 'user', 'pass', $charset, $pconnect)***
   <br>В данной строке изменяем данные входа в базу данных.
 * ***$domain_name = 'torrentpier.com';***
   <br>В данной строке указываем ваше доменное имя. Остальные правки в файле вносятся по усмотрению, исходя из необходимости из внесения (ориентируйтесь на описания, указанные у полей).
 * ***$domain_ssl = false;***
   <br>В данной строке ставим значение true, если имеется SSL сертификат (HTTPS). При значении false (По умолчанию) скрипт сам определяет наличие SSL сертификата.

4. Редактируем указанные файлы:
 + **favicon.ico** (меняем на свою иконку, если есть)
 + **robots.txt** (меняем адреса в строках **Host** и **Sitemap** на свои)
 + **opensearch_desc.xml** (меняем описание и адрес на свои)
 + **opensearch_desc_bt.xml** (меняем описание и адрес на свои)

## 💽️ Обновление движка

Обновление движка с R400 до 2.1 (R600)
* Если у вас установлена версия движка ниже чем **2.1 (R600)**, то воспользуйтесь инструкцией из [этой статьи](https://torrentpier.com/threads/obnovlenie-dvizhka-do-versii-2-1-r600.26147/), данная инструкция поможет обновить движок до состояния **2.1 (R600)**, что позволит приступить к следующему шагу в обновлении движка уже с **2.1 (R600)** до **2.1.5-LTS последней ревизии**. <br>**Если у вас уже стоит версия 2.1 (R600) или новее, то этот шаг нужно пропустить!**

Обновление движка с 2.1 (R600) до 2.1.5-LTS
* Приступая к этому шагу, убедитесь что у вас движок по состоянию соответствует **2.1 (R600)** версии, если же нет, то вернитесь к прошлому шагу. <br>Итак, для обновления движка посмотрите [данную инструкцию](https://torrentpier.com/threads/obnovlenie-dvizhka-do-versii-2-1-5-lts.42187/), которая поможет вам обновить ваш движок до состояния последней LTS версии.

## 🔑 Права доступа на папки и файлы

Исходя из настроек вашего сервера, устанавливаем рекомендуемые права доступа (chmod) на указанные папки **777**, а на файлы внутри этих папок (кроме файлов **.htaccess** и **.keep**) **666**:
- data/avatars
- data/old_files
- data/old_files/thumbs
- data/torrent_files
- internal_data/ajax_html
- internal_data/atom
- internal_data/cache
- internal_data/log
- internal_data/sitemap
- internal_data/triggers

## ⚓️ Необходимая версия php

Минимально поддерживаемой версией PHP в настоящий момент является **5.3.4**. Существует поддержка вплоть до **5.6** последних версий. **Поддержка PHP 7 отсутствует**.

## ⚓️ Необходимые настройки php

	mbstring.internal_encoding = UTF-8
	magic_quotes_gpc = Off
Внести данные настройки необходимо в файл **php.ini**. Их вам может установить ваш хостер по запросу, если у вас возникают какие-либо проблемы с их самостоятельной установкой. Впрочем, эти настройки могут быть установлены на сервере по-умолчанию, поэтому их внесение требуется исключительно по необходимости.

## ⚓️ Необходимые модули php

	php5-tidy
	mbstring
	bcmath
	intl
	mysql
Начиная с версии **2.0.9** (**ревизия 592** в старой нумерации) модуль **php5-tidy** не является обязательным, но его установка крайне рекомендуется для повышения качества обработки html-кода тем и сообщений пользователей.

## ⚓️ Рекомендуемый способ запуска cron.php

Для значительного ускорения работы трекера может потребоваться отвязка встроенного форумного крона. С более подробной информацией об отвязке крона, вы можете ознакомиться в данной теме https://torrentpier.com/threads/52/ на нашем форуме поддержки.

## ⚓️ Локальный файл конфигурации

Начиная с **ревизии 599** была добавлена поддержка автоматического подключения файла **library/config.local.php**, при создании его вами. Данный файл является заменой **library/config.php** для конкретного сервера, на котором запущен трекер. (При создании **library/config.local.php** он будет загружаться вместо **library/config.php**).

## ⚓️ Файл конфигурации для модов

Начиная с версии **v2.1.5-2023.09** была добавлена автоматическая загрузка настроек для модификаций из файла **library/config.mods.php**. Данный файл уже присутствует по-умолчанию, при желании его можно удалить. Настройки для модификаций лучше указывать именно в нем, вместо того чтобы писать их в **library/config.php**. Это сделано для удобства, чтобы отделить настройки движка и настройки модов.

## ⚓️ Установка Ocelot

В движок встроена по-умолчанию поддержка альтернативного компилируемого анонсера - Ocelot. Настройка производится в файле **library/config.php**, сам анонсер находится в [этом репозитории](https://github.com/torrentpier/ocelot).

Инструкция по сборке приведена на нашем форуме: https://torrentpier.com/threads/sborka-ocelot-pod-debian-7-1.26078/
Для работы анонсера требуется замена двух таблиц в базе данных - дамп в файле: **install/sql/ocelot.sql**.

## ⚓️ Папка install

В корне движка присутствует папка **install**, в которой находятся служебные файлы, необходимые для его установки (дамп базы, примеры конфигов) и обновления (дамперы, скрипты конвертации). Доступ к данной папке по-умолчанию закрыт, но если ее присутствие вам мешает - вы можете ее удалить. На файлы **README.md**, **.git**, **.github**, **.gitignore**, **CHANGELOG.md**, **CODE_OF_CONDUCT.md** и **CONTRIBUTORS.md** это также распространяется.

## 📌 Полезные ссылки

+ Наш форум https://torrentpier.com/
+ Центр загрузки https://get.torrentpier.com/
+ Часто задаваемые вопросы https://faq.torrentpier.com/
+ Где задать вопрос https://torrentpier.com/forums/10/
