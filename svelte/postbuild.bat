ECHO OFF

echo "Rename .js and .css file and copy to dist directory"

SET "path=%~dp0dist"

::renmae js
for /R %path% %%f in (*.js) do (
	ren %%f smj-ulm-cal-public.js
)

::rename css
for /R %path% %%f in (*.css) do (
	ren %%f smj-ulm-cal-public.css
)


::copy css file
SET "copy_path=%~dp0\..\smj-ulm-cal\public\css"
for /R %path% %%f in (*.css) do (
	copy %%f %copy_path%
)

::copy js file
SET "copy_path=%~dp0\..\smj-ulm-cal\public\js"
for /R %path% %%f in (*.js) do (
	copy %%f %copy_path%
)
