# Efecte-Data-Import

Efecte Data Import is a script to format simple Excel (csv) Files to valid xml-imports for [efecte](https://www.efecte.com/de/). The script is written in php an you can change it as you need it.

## Installation

To use the skript you need to **install PHP on your Computer**. 
One way to achieve that, is to install [XAMPP](https://www.apachefriends.org/de/index.html) and [add to the PATH-Variable](https://john-dugan.com/add-php-windows-path-variable/) the C:\xampp\php directory. To check if everything works fine, simply type `php` in your Terminal (CMD). If no error shows up, every thing is ok.

## Usage

**Edit the data in Excel to fit ESM:**
1. the first row of the table must fit to the ESM attribute codes of efecte
2. delete the unnecessary columns and rows
3. save the file as a *tab delimited text file* (German: CSV UTF-8 - durch Trennzeichen getrennt)
4. name the file with the same efecte template code you want to import (e.q. person, location, ...)

**Convert the CSV (Excel) file to XML**
1. move the file into the same direcotry as your script
2. open a bash and navigate to the directory
3. execute:

```bash
> php CONVERT [location.csv] [location-import-efecte.xml]
```

**Import the XML to efecte**
1. follow the instructions in the manual

***The file name of the .csv need to match to the efecte template code (e.q. location, asset, ...)***

## Example Files

* `example/entityset-location.xml` is a exported xml file from efecte
* `example/entityset-location-minimal.xml` is the minimal set of attributes and elements required for efecte import

## Author

**Lukas Dumberger**

[https://dumbergerl.de](https://dumbergerl.de)

## Licence

Copyright 2019, Lukas Dumberger

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.