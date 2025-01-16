<?php


class Library
{
    public ?string $name;
    public ?string $address;
    protected ?array $Bookcases = [];

    public function __construct(?string $name,?string $address)
    {
        $this->name = $name;
        $this->address = $address;
    }

    public function addBookcase(Bookcase $Bookcase): void
    {
        $this->Bookcases[] = $Bookcase;
    }

    public function getBookcase($BookcaseNumber): ?Bookcase
    {
        foreach ($this->Bookcases as $Bookcase) {
            if ($Bookcase->number === $BookcaseNumber) {
                return $Bookcase;
            }
        }
        return null;
    }

    public function displayInfo():void
    {
        echo "Library: " . $this->name . ", Address: " . $this->address . "\n";
        echo "Bookcases:\n";
        foreach ($this->Bookcases as $Bookcase) {
            $Bookcase->displayInfo();
        }
    }
}

class Bookcase
{
    public ?int $number;
    protected ?array $books = [];

    public function __construct(?int $number)
    {
        $this->number = $number;
    }

    public function addBook(Book $book): void
    {
        $this->books[] = $book;
    }


    public function findBookByTitle($title): ?Book
    {
        foreach ($this->books as $book) {
            if ($book->title === $title) {
                return $book;
            }
        }
        return null;
    }


    public function displayInfo():void
    {
        echo " Bookcase #" . $this->number . "\n";
        echo " Books:\n";
        foreach ($this->books as $book) {
            $book->displayInfo();
        }
    }
}

class Book
{
    public ?string $title;
    public ?string $author;

    public function __construct(?string $title,?string $author)
    {
        $this->title = $title;
        $this->author = $author;
    }

    public function displayInfo():void
    {
        echo "    Title: " . $this->title . ", Author: " . $this->author . "\n";
    }
}

$library = new Library("Central Library", "Main Street 1");

$Bookcase1 = new Bookcase(1);
$Bookcase2 = new Bookcase(2);


$book1 = new Book("The Lord of the Rings", "J.R.R. Tolkien");
$book2 = new Book("Pride and Prejudice", "Jane Austen");
$book3 = new Book("1984", "George Orwell");

$Bookcase1->addBook($book1);
$Bookcase1->addBook($book2);
$Bookcase2->addBook($book3);

$library->addBookcase($Bookcase1);
$library->addBookcase($Bookcase2);


$library->displayInfo();

$foundBookcase = $library->getBookcase(1);
$foundBook = $foundBookcase->findBookByTitle("Pride and Prejudice");
if ($foundBook) {
    echo "\nFound Book:\n";
    $foundBook->displayInfo();
} else {
    echo "\nBook not found.\n";
}