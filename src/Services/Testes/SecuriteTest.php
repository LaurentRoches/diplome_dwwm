<?php

use src\Services\Securite;

require_once __DIR__."/../Securite.php";

class SecuriteTest {

    use Securite;

    public function testSanitizeSimpleArray() {
        $data = [
            'name' => '<script>alert("test")</script>',
            'email' => 'user@example.com'
        ];

        $expected = [
            'name' => '&lt;script&gt;alert(&quot;test&quot;)&lt;/script&gt;',
            'email' => 'user@example.com'
        ];

        $result = $this->sanitize($data);
        assert($result === $expected, 'Simple array sanitization failed');
        echo "testSanitizeSimpleArray passed.\n";
    }

    public function testSanitizeNestedArray() {
        $data = [
            'user' => [
                'name' => '<b>John</b>',
                'details' => [
                    'age' => 25,
                    'bio' => '<i>Developer</i>'
                ]
            ]
        ];

        $expected = [
            'user' => [
                'name' => '&lt;b&gt;John&lt;/b&gt;',
                'details' => [
                    'age' => 25,
                    'bio' => '&lt;i&gt;Developer&lt;/i&gt;'
                ]
            ]
        ];

        $result = $this->sanitize($data);
        assert($result === $expected, 'Nested array sanitization failed');
        echo "testSanitizeNestedArray passed.\n";
    }

    public function testSanitizeStdClass() {
        $data = new stdClass();
        $data->name = '<h1>Title</h1>';
        $data->email = 'test@example.com';

        $expected = [
            'name' => '&lt;h1&gt;Title&lt;/h1&gt;',
            'email' => 'test@example.com'
        ];

        $result = $this->sanitize($data);
        assert($result === $expected, 'stdClass sanitization failed');
        echo "testSanitizeStdClass passed.\n";
    }
}

$test = new SecuriteTest();
$test->testSanitizeSimpleArray();
$test->testSanitizeNestedArray();
$test->testSanitizeStdClass();
