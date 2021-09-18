<?php

namespace App\Auxiliary {
    use Slate\Mvc\Env;
    use Slate\IO\File;
    use Slate\Exception\IOException;
    use Slate\Exception\ParseException;

    class Vite {
        protected string $dist;
        protected array $manifest;

        public function __construct(string $dist = "dist") {
            $this->dist = \Str::trimAffix($dist, "/");
            $manifestPath = Env::format("{mvc.public.path}/{dist}/manifest.json", [
                "dist" => $this->dist
            ]);

            if(File::exists($manifestPath)) {
                $manifestFile = new File($manifestPath);
                $manifestFile->open("r");

                $manifestContents = $manifestFile->readAll();

                if($manifestContents !== null) {
                    if(($manifestJson = json_decode($manifestContents, true)) === false) {
                        throw new ParseException("Unable to parse the manifest file.");
                    }

                    $this->manifest = $manifestJson;
                }

                $manifestFile->close();
            }
            else {
                throw new IOException("Vite manifest file was not found, confirm the `build.manifest` option is set to true.");
            }
        }

        public function resolve(string $asset): string {
            return "/".$this->dist."/".$asset;
        }

        public function asset(string $name): string {
            return \Arr::hasKey($this->manifest, $name) ? $this->resolve($this->manifest[$name]["file"]) : null;
        }

        public function imports(string $name): array {
            $paths = [];

            if(\Arr::hasKey($this->manifest, $name)) {
                foreach($this->manifest[$name]["imports"] as $import) {
                    $paths[] = $this->asset($import);
                }
            }

            return $paths;
        }

        public function css(string $name): array {
            $paths = [];

            if(\Arr::hasKey($this->manifest, $name)) {
                foreach($this->manifest[$name]["css"] ?: [] as $import) {
                    $paths[] = $this->resolve($import);
                }
            }

            return $paths;
        }

        public function toString(string $entry): string {
            $stack = [];

            // JS Preloads
            foreach($this->imports($entry) as $path) {
                $stack[] = '<link rel="modulepreload" href="' . $path . '"/>';
            }

            // CSS Preloads
            foreach($this->css($entry) as $path) {
                $stack[] = '<link rel="stylesheet" href="' . $path . '">';
            }

            $stack[] = '<script type="module" crossorigin src="' . $this->asset($entry)  . '"></script>';

            return \Arr::join($stack, "\r\n");
        }
    }
}

?>