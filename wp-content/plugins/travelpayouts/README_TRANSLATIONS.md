#### Локализация .pot

Для того чтобы обновить файл локализации плагина необходимо, в корне проекта, выполнить команду

`npm install`

Затем, после успешной установки, выполнить команду

`wpi18n makepot --exclude vendor,tmp,redux-core`

После успешного выполнения, загружаем обновленный файл `/languages/travelpayouts.pot` в crowdin