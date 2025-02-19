@echo off
"C:\Program Files\gs\gs10.04.0\bin\gswin64c" -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH -sOutputFile="%1" "%2"