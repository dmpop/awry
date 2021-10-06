# RAW Cow

Simple PHP-based web application for instant RAW processing and publishing. RAW Cow can extract JPEG images embedded into RAW files or it can use [darktable](https://www.darktable.org/) to convert RAW files to JPEG. The application publishes the resulting JPEG files as a responsive gallery. RAW Cow also makes it possible to apply Hald CLUT presets to the JPEG files.

<img src="raw-cow.png" alt="RAW Cow">

## Dependencies

- PHP
- ExifTool
- darktable (optional)
- Web server (Apache, Lighttpd, or similar)
- Git (optional)

## Installation and usage

1. Make sure that your local machine or remote web server has PHP and ExiTool installed.
2. Clone the project's repository using the `git clone https://github.com/dmpop/raw-cow.git` command. Alternatively, download the latest source code using the appropriate button on the project's page.
3. Open the _raw-cow/config.php_ file and change example values, if necessary.
4. Put RAW files into _raw-cow/RAW_ directory.
5. To run RAW Cow locally, switch in the terminal to the _raw-cow_ directory,  run the `php -S 127.0.0.1:8000` command, and point the browser to the _127.0.0.1:8000_ address.

The [Linux Photography](https://gumroad.com/l/linux-photography) book provides detailed information  on installing and using Natsukashii. Get your copy at [Google Play Store](https://play.google.com/store/books/details/Dmitri_Popov_Linux_Photography?id=cO70CwAAQBAJ) or [Gumroad](https://gumroad.com/l/linux-photography).

<img src="https://tinyvps.xyz/img/linux-photography.jpeg" title="Linux Photography book" width="200"/>

## Problems?

Please report bugs and issues in the [Issues](https://github.com/dmpop/raw-cow/issues) section.

## Contribute

If you've found a bug or have a suggestion for improvement, open an issue in the [Issues](https://github.com/dmpop/raw-cow/issues) section.

To add a new feature or fix issues yourself, follow the following steps.

1. Fork the project's repository.
2. Create a feature branch using the `git checkout -b new-feature` command.
3. Add your new feature or fix bugs and run the `git commit -am 'Add a new feature'` command to commit changes.
4. Push changes using the `git push origin new-feature` command.
5. Submit a pull request.

## Author

[Dmitri Popov](https://www.tokyoma.de/)

# License

The [GNU General Public License version 3](http://www.gnu.org/licenses/gpl-3.0.en.html)
