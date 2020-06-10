import React from "react";
import ReactDOM from "react-dom";
import Starter from "./Starter";

class App extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            content: 'Salut ! '
        }
    }

    /**
     * Update the App state via a `Starter` component
     * @param content
     */
    contentChange (content) {
        this.setState({ content })
    }

    render() {
        return (
            <div>
                {[...Array(3).keys()].map(idx => (
                    <div>
                        <Starter
                            key={idx.toString()}
                            onContentChange={(content) => this.contentChange(content)}
                            content={this.state.content}
                        />
                    </div>
                ))}
            </div>
        )
    }
}

ReactDOM.render(<App />, document.getElementById('root'));
