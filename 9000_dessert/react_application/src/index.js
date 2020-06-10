const fetch = require('node-fetch');
import React from "react";
import ReactDOM from "react-dom";
import Person from "./Person";

const URL = 'https://kodaktor.ru/j/users';

class PersonList extends React.Component{
    constructor(props) {
        super(props);

        this.state = {
            persons: []
        };
    }

    componentDidMount() {
        fetch(URL)
            .then(res => res.json())
            .then(({ users }) => this.setState({ persons: users }))
        ;
    }

    render() {
        return (
          <ol>
              {this.state.persons.map(person =>
                  <Person
                    name={person.login}
                  />
              )}
          </ol>
        );
    }
}

ReactDOM.render(<PersonList />, document.getElementById('root'));
