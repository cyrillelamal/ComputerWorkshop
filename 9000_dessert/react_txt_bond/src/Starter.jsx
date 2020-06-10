import React, { Component } from "react"

class Starter extends Component{
    constructor(props) {
        super(props);

        this.state = {
            content: props.content
        }
    }

    handleChange (event) {
        const content = event.currentTarget.value

        this.setState({ content })

        this.props.onContentChange(content)
    }

    render() {
        return (
            <input
                value={this.props.content}
                onChange={this.handleChange.bind(this)}
                type="text"
                placeholder="Nous sommes liés"
            />
        )
    }
}

export default Starter
