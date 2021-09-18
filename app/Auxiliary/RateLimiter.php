<?php

namespace App\Auxiliary {

    use Slate\Data\IRepository;
    use Slate\IO\SysvSharedMemoryRepository;
    use Slate\IO\SysvSharedMemoryTable;
    use Slate\Mvc\Env;
    use Slate\Utility\Facade;
    use Slate\Utility\TImitate;
    use Slate\Utility\TSingleton;
    use Slate\Mvc\App;

    final class RateLimiter {
        use TSingleton;

        public const SINGLETON_CALLABLE = TRUE;

        protected string $repository;

        protected function __construct(string $repository) {
            $this->repository = $repository;
        }
        
        public function clear(): void {
            App::repo($this->repository)->flush();
        }
        
        public function tooManyAttempts(string $ip, int $maxAttempts): bool {
            return $this->attempts($ip) >= $maxAttempts;
        }

        public function hit(string $key, int $decay = 60): void {
            App::repo($this->repository)->modify($key, function($value) {
                return (intval($value) ?: 0) + 1;
            }, $decay);
        }
        
        public function attempts(string $ip): int {
            return App::repo($this->repository)->pull($ip, 0);
        }

        public function attemptsRemaining(string $ip, int $maxAttempts): int {
            return $maxAttempts - $this->attempts($ip);
        }

        public static function createInstance(): object {
            return new static("shm:ratelimiter");
        }
    }
}

?>