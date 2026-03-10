<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Tag;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::truncate();
        $tags = Tag::all();
        
         $books = [
            ['The Hobbit','J.R.R. Tolkien',1937,['Fantasy','Adventure']],
            ['The Lord of the Rings','J.R.R. Tolkien',1954,['Fantasy','Adventure']],
            ['1984','George Orwell',1949,['Dystopian','Science Fiction','Classic']],
            ['Animal Farm','George Orwell',1945,['Dystopian','Classic']],
            ['Brave New World','Aldous Huxley',1932,['Dystopian','Science Fiction','Classic']],
            ['Fahrenheit 451','Ray Bradbury',1953,['Dystopian','Science Fiction']],
            ['Dune','Frank Herbert',1965,['Science Fiction','Adventure']],
            ['Foundation','Isaac Asimov',1951,['Science Fiction','Classic']],
            ['Neuromancer','William Gibson',1984,['Science Fiction']],
            ['Snow Crash','Neal Stephenson',1992,['Science Fiction']],
            ['Dracula','Bram Stoker',1897,['Horror','Classic']],
            ['Frankenstein','Mary Shelley',1818,['Horror','Science Fiction','Classic']],
            ['The Shining','Stephen King',1977,['Horror','Thriller']],
            ['It','Stephen King',1986,['Horror']],
            ['Pet Sematary','Stephen King',1983,['Horror']],
            ['The Da Vinci Code','Dan Brown',2003,['Mystery','Thriller']],
            ['Angels & Demons','Dan Brown',2000,['Mystery','Thriller']],
            ['Gone Girl','Gillian Flynn',2012,['Thriller','Mystery']],
            ['The Girl with the Dragon Tattoo','Stieg Larsson',2005,['Mystery','Thriller']],
            ['Sherlock Holmes: A Study in Scarlet','Arthur Conan Doyle',1887,['Mystery','Classic']],
            ['Pride and Prejudice','Jane Austen',1813,['Romance','Classic','Drama']],
            ['Jane Eyre','Charlotte Brontë',1847,['Romance','Classic','Drama']],
            ['Wuthering Heights','Emily Brontë',1847,['Romance','Classic','Drama']],
            ['The Notebook','Nicholas Sparks',1996,['Romance','Drama']],
            ['Me Before You','Jojo Moyes',2012,['Romance','Drama']],
            ['The Catcher in the Rye','J.D. Salinger',1951,['Classic','Drama','Young Adult']],
            ['To Kill a Mockingbird','Harper Lee',1960,['Classic','Drama']],
            ['The Great Gatsby','F. Scott Fitzgerald',1925,['Classic','Drama']],
            ['Of Mice and Men','John Steinbeck',1937,['Classic','Drama']],
            ['The Grapes of Wrath','John Steinbeck',1939,['Classic','Drama']],
            ['The Hunger Games','Suzanne Collins',2008,['Dystopian','Adventure','Young Adult']],
            ['Catching Fire','Suzanne Collins',2009,['Dystopian','Adventure','Young Adult']],
            ['Mockingjay','Suzanne Collins',2010,['Dystopian','Adventure','Young Adult']],
            ['Divergent','Veronica Roth',2011,['Dystopian','Young Adult']],
            ['The Maze Runner','James Dashner',2009,['Dystopian','Science Fiction','Young Adult']],
            ['The Alchemist','Paulo Coelho',1988,['Philosophy','Adventure']],
            ['Siddhartha','Hermann Hesse',1922,['Philosophy','Classic']],
            ['Meditations','Marcus Aurelius',180,['Philosophy','Classic']],
            ['Thus Spoke Zarathustra','Friedrich Nietzsche',1883,['Philosophy','Classic']],
            ['Atomic Habits','James Clear',2018,['Self Development','Psychology']],
            ['The 7 Habits of Highly Effective People','Stephen Covey',1989,['Self Development']],
            ['Think and Grow Rich','Napoleon Hill',1937,['Self Development']],
            ['Deep Work','Cal Newport',2016,['Self Development']],
            ['The Psychology of Money','Morgan Housel',2020,['Psychology','Self Development']],
            ['Man’s Search for Meaning','Viktor Frankl',1946,['Psychology','Philosophy']],
            ['The Road','Cormac McCarthy',2006,['Dystopian','Drama']],
            ['A Clockwork Orange','Anthony Burgess',1962,['Dystopian','Classic']],
            ['The Handmaid’s Tale','Margaret Atwood',1985,['Dystopian','Science Fiction']],
            ['Oryx and Crake','Margaret Atwood',2003,['Science Fiction','Dystopian']],
            ['Treasure Island','Robert Louis Stevenson',1883,['Adventure','Classic']],
            ['Robinson Crusoe','Daniel Defoe',1719,['Adventure','Classic']],
            ['Around the World in 80 Days','Jules Verne',1873,['Adventure','Science Fiction']],
            ['Journey to the Center of the Earth','Jules Verne',1864,['Adventure','Science Fiction']],
            ['The Name of the Wind','Patrick Rothfuss',2007,['Fantasy']],
            ['The Way of Kings','Brandon Sanderson',2010,['Fantasy','Adventure']],
            ['Mistborn: The Final Empire','Brandon Sanderson',2006,['Fantasy']],
            ['A Game of Thrones','George R.R. Martin',1996,['Fantasy','Adventure']],
            ['The Lies of Locke Lamora','Scott Lynch',2006,['Fantasy']],
            ['The Martian','Andy Weir',2011,['Science Fiction']],
            ['Project Hail Mary','Andy Weir',2021,['Science Fiction']],
            ['Ready Player One','Ernest Cline',2011,['Science Fiction','Adventure']],
            ['The Fault in Our Stars','John Green',2012,['Young Adult','Romance']],
            ['Looking for Alaska','John Green',2005,['Young Adult','Drama']],
            ['Paper Towns','John Green',2008,['Young Adult']],
            ['The Book Thief','Markus Zusak',2005,['Historical','Drama']],
            ['All the Light We Cannot See','Anthony Doerr',2014,['Historical','Drama']],
            ['The Pillars of the Earth','Ken Follett',1989,['Historical','Drama']],
            ['War and Peace','Leo Tolstoy',1869,['Historical','Classic']],
            ['The Kite Runner','Khaled Hosseini',2003,['Drama']],
            ['Crime and Punishment','Fyodor Dostoevsky',1866,['Classic','Drama']],
            ['The Brothers Karamazov','Fyodor Dostoevsky',1880,['Classic','Philosophy']],
            ['Anna Karenina','Leo Tolstoy',1877,['Classic','Drama','Romance']],
            ['Don Quixote','Miguel de Cervantes',1605,['Classic','Adventure']],
            ['The Odyssey','Homer',-700,['Classic','Adventure']],
            ['The Iliad','Homer',-750,['Classic','Adventure']],
            ['The Stand','Stephen King',1978,['Horror','Dystopian']],
            ['Carrie','Stephen King',1974,['Horror']],
            ['Misery','Stephen King',1987,['Thriller','Horror']],
            ['The Silent Patient','Alex Michaelides',2019,['Thriller','Mystery']],
            ['Before I Go to Sleep','S.J. Watson',2011,['Thriller']],
            ['Shutter Island','Dennis Lehane',2003,['Thriller','Mystery']],
            ['Educated','Tara Westover',2018,['Drama']],
            ['Sapiens','Yuval Noah Harari',2011,['Historical','Philosophy']],
            ['Homo Deus','Yuval Noah Harari',2015,['Philosophy']],
            ['21 Lessons for the 21st Century','Yuval Noah Harari',2018,['Philosophy']]
        ];

        foreach ($books as $data) {

            [$title,$author,$year,$tags] = $data;

            $book = Book::create([
                'title' => $title,
                'author' => $author,
                'release_year' => $year,
                'description' => null
            ]);

            $tagIds = Tag::whereIn('name',$tags)->pluck('id');

            $book->tags()->sync($tagIds);
        }
    }
}
